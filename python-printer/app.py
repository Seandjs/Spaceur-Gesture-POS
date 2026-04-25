from flask import Flask, request, jsonify
from flask_cors import CORS
import os
from datetime import datetime

try:
    import win32print
except ImportError:
    win32print = None

app = Flask(__name__)
CORS(app)

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
RECEIPT_DIR = os.path.join(BASE_DIR, "receipts")
os.makedirs(RECEIPT_DIR, exist_ok=True)


def money(value: int) -> str:
    return f"{value:,.0f}".replace(",", ".")


def format_line(left: str, right: str, width: int = 40) -> str:
    left = str(left)
    right = str(right)

    space = width - len(left) - len(right)
    if space < 1:
        return f"{left}\n{' ' * max(width - len(right), 0)}{right}"
    return f"{left}{' ' * space}{right}"


def build_receipt(data: dict) -> str:
    invoice = data.get("invoice_number", "-")
    total = int(data.get("total_amount", 0))
    items = data.get("items", [])

    lines = []
    lines.append("SPACEUR CASHIER")
    lines.append("Gesture POS System")
    lines.append("=" * 40)
    lines.append(f"Invoice : {invoice}")
    lines.append(f"Tanggal : {datetime.now().strftime('%d-%m-%Y %H:%M:%S')}")
    lines.append("=" * 40)

    for item in items:
        name = item.get("name", "Produk")
        size = item.get("size", "")
        qty = int(item.get("qty", 0))
        price = int(item.get("price", 0))
        subtotal = int(item.get("subtotal", 0))

        product_name = f"{name} {size}".strip()
        lines.append(product_name[:40])
        lines.append(format_line(f"{qty} x {money(price)}", money(subtotal)))
        lines.append("-" * 40)

    lines.append(format_line("TOTAL", money(total)))
    lines.append("=" * 40)
    lines.append("Terima kasih")
    lines.append("")
    lines.append("")
    lines.append("")

    return "\n".join(lines)


def save_receipt(receipt_text: str, invoice_number: str) -> str:
    filename = f"{invoice_number}.txt"
    file_path = os.path.join(RECEIPT_DIR, filename)

    with open(file_path, "w", encoding="utf-8") as f:
        f.write(receipt_text)

    return file_path


def print_raw_text(receipt_text: str, printer_name: str | None = None) -> tuple[bool, str]:
    if win32print is None:
        return False, "pywin32 belum terpasang"

    try:
        target_printer = printer_name or win32print.GetDefaultPrinter()
        printer = win32print.OpenPrinter(target_printer)

        try:
            job = win32print.StartDocPrinter(printer, 1, ("Receipt", None, "RAW"))
            win32print.StartPagePrinter(printer)
            win32print.WritePrinter(printer, receipt_text.encode("ascii", errors="replace"))
            win32print.EndPagePrinter(printer)
            win32print.EndDocPrinter(printer)
        finally:
            win32print.ClosePrinter(printer)

        return True, f"Berhasil mencetak ke printer: {target_printer}"
    except Exception as e:
        return False, str(e)


@app.get("/health")
def health():
    return jsonify({
        "success": True,
        "message": "Python printer service aktif"
    })


@app.post("/print")
def print_receipt():
    try:
        data = request.get_json(force=True)
        invoice_number = data.get("invoice_number", f"INV-{int(datetime.now().timestamp())}")

        receipt_text = build_receipt(data)
        saved_file = save_receipt(receipt_text, invoice_number)

        success, print_message = print_raw_text(
            receipt_text,
            data.get("printer_name")
        )

        return jsonify({
            "success": success,
            "message": print_message,
            "saved_file": saved_file,
            "invoice_number": invoice_number
        })
    except Exception as e:
        return jsonify({
            "success": False,
            "message": str(e)
        }), 500


if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5001, debug=True)