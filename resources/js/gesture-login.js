import { FilesetResolver, HandLandmarker } from "@mediapipe/tasks-vision";

const video = document.getElementById("gesture-video");
const canvas = document.getElementById("gesture-canvas");
const ctx = canvas ? canvas.getContext("2d") : null;

const startBtn = document.getElementById("start-camera-btn");
const resetBtn = document.getElementById("reset-gesture-btn");

const gestureNameEl = document.getElementById("gesture-name");
const gestureProgressEl = document.getElementById("gesture-progress");
const gestureStatusEl = document.getElementById("gesture-status");

// KODE RAHASIA
const secretSequence = ["peace", "okay", "salute"];

// Gesture pengecoh yang tetap dikenali sistem
const supportedGestures = [
    "one",
    "two",
    "three",
    "peace",
    "okay",
    "metal",
    "relax",
    "salute",
];

let currentStep = 0;
let handLandmarker = null;
let stream = null;
let lastVideoTime = -1;
let lastAcceptedGesture = null;
let lastDetectedGesture = null;
let isSending = false;
let animationFrameId = null;

const HAND_CONNECTIONS = [
    [0,1],[1,2],[2,3],[3,4],
    [0,5],[5,6],[6,7],[7,8],
    [5,9],[9,10],[10,11],[11,12],
    [9,13],[13,14],[14,15],[15,16],
    [13,17],[17,18],[18,19],[19,20],
    [0,17]
];

function setStatus(text) {
    if (gestureStatusEl) gestureStatusEl.textContent = text;
}

function setGestureName(text) {
    if (gestureNameEl) gestureNameEl.textContent = text;
}

function updateProgressUI() {
    if (!gestureProgressEl) return;
    gestureProgressEl.textContent = `${currentStep} / ${secretSequence.length}`;
}

function resetProgress(message = "Progress direset") {
    currentStep = 0;
    lastAcceptedGesture = null;
    updateProgressUI();
    setStatus(message);
}

function distance(a, b) {
    const dx = a.x - b.x;
    const dy = a.y - b.y;
    return Math.sqrt(dx * dx + dy * dy);
}

function fingerUp(landmarks, tipIndex, pipIndex) {
    return landmarks[tipIndex].y < landmarks[pipIndex].y;
}

function drawLandmarks(landmarks) {
    if (!ctx || !canvas) return;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    if (!landmarks || landmarks.length === 0) return;

    ctx.strokeStyle = "#ffffff";
    ctx.lineWidth = 2;

    for (const [startIndex, endIndex] of HAND_CONNECTIONS) {
        const start = landmarks[startIndex];
        const end = landmarks[endIndex];

        ctx.beginPath();
        ctx.moveTo(start.x * canvas.width, start.y * canvas.height);
        ctx.lineTo(end.x * canvas.width, end.y * canvas.height);
        ctx.stroke();
    }

    ctx.fillStyle = "#ffffff";

    for (const point of landmarks) {
        const x = point.x * canvas.width;
        const y = point.y * canvas.height;

        ctx.beginPath();
        ctx.arc(x, y, 4, 0, Math.PI * 2);
        ctx.fill();
    }
}

function resizeCanvasToVideo() {
    if (!video || !canvas) return;
    if (!video.videoWidth || !video.videoHeight) return;

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
}

function detectGesture(landmarks) {
    const thumbTip = landmarks[4];
    const indexTip = landmarks[8];

    const indexUp = fingerUp(landmarks, 8, 6);
    const middleUp = fingerUp(landmarks, 12, 10);
    const ringUp = fingerUp(landmarks, 16, 14);
    const pinkyUp = fingerUp(landmarks, 20, 18);

    const thumbIndexClose = distance(thumbTip, indexTip) < 0.06;

    // relax / santai / fist
    if (!indexUp && !middleUp && !ringUp && !pinkyUp) {
        return "relax";
    }

    // one
    if (indexUp && !middleUp && !ringUp && !pinkyUp && !thumbIndexClose) {
        return "one";
    }

    // peace / two
    if (indexUp && middleUp && !ringUp && !pinkyUp && !thumbIndexClose) {
        return "peace";
    }

    // three
    if (indexUp && middleUp && ringUp && !pinkyUp && !thumbIndexClose) {
        return "three";
    }

    // metal (telunjuk + kelingking)
    if (indexUp && !middleUp && !ringUp && pinkyUp && !thumbIndexClose) {
        return "metal";
    }

    // okay
    if (thumbIndexClose && middleUp && ringUp && pinkyUp) {
        return "okay";
    }

    // salute = open palm
    if (indexUp && middleUp && ringUp && pinkyUp && !thumbIndexClose) {
        return "salute";
    }

    return null;
}

async function initHandLandmarker() {
    const vision = await FilesetResolver.forVisionTasks(
        "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@latest/wasm"
    );

    handLandmarker = await HandLandmarker.createFromOptions(vision, {
        baseOptions: {
            modelAssetPath: "/models/hand_landmarker.task",
        },
        runningMode: "VIDEO",
        numHands: 1,
        minHandDetectionConfidence: 0.5,
        minHandPresenceConfidence: 0.5,
        minTrackingConfidence: 0.5,
    });
}

async function startCamera() {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        throw new Error("Browser tidak mendukung akses kamera");
    }

    if (stream) {
        stream.getTracks().forEach((track) => track.stop());
    }

    stream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false,
    });

    video.srcObject = stream;
    await video.play();

    resizeCanvasToVideo();
    setStatus("Kamera aktif");

    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
    }

    renderLoop();
}

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach((track) => track.stop());
        stream = null;
    }

    if (video) {
        video.pause();
        video.srcObject = null;
    }

    if (ctx && canvas) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    setGestureName("Belum ada");
    resetProgress("Kamera dihentikan");
    lastDetectedGesture = null;
}

async function sendGesturePassed() {
    if (isSending) return;
    isSending = true;

    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        const response = await fetch("/cashier/gesture-pass", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken || "",
                "Accept": "application/json",
            },
            body: JSON.stringify({ passed: true }),
        });

        const result = await response.json();

        if (result.success && result.redirect) {
            setStatus("Kode valid, masuk ke POS...");
            window.location.href = result.redirect;
            return;
        }

        setStatus("Kode valid, tapi redirect gagal");
        isSending = false;
    } catch (error) {
        console.error("Send gesture pass error:", error);
        setStatus("Gagal mengirim status login");
        isSending = false;
    }
}

function processGesture(gesture) {
    if (!gesture) {
        setGestureName("Belum dikenali");
        return;
    }

    if (!supportedGestures.includes(gesture)) {
        return;
    }

    setGestureName(gesture);

    // cegah baca gesture yang sama berulang-ulang terus
    if (gesture === lastDetectedGesture) {
        return;
    }

    lastDetectedGesture = gesture;

    const expectedGesture = secretSequence[currentStep];

    if (gesture === expectedGesture) {
        currentStep++;
        lastAcceptedGesture = gesture;
        updateProgressUI();

        if (currentStep >= secretSequence.length) {
            setStatus("Kode gesture lengkap");
            sendGesturePassed();
        } else {
            setStatus("Gesture benar");
        }

        return;
    }

    // kalau gesture salah dan dia termasuk gesture valid lain -> reset
    if (gesture !== expectedGesture) {
        resetProgress("Gesture salah, ulang dari awal");
    }
}

function renderLoop() {
    if (!handLandmarker || !video || video.readyState < 2) {
        animationFrameId = requestAnimationFrame(renderLoop);
        return;
    }

    if (video.currentTime !== lastVideoTime) {
        const result = handLandmarker.detectForVideo(video, performance.now());
        lastVideoTime = video.currentTime;

        if (result.landmarks && result.landmarks.length > 0) {
            drawLandmarks(result.landmarks[0]);

            const gesture = detectGesture(result.landmarks[0]);
            processGesture(gesture);
        } else {
            if (ctx && canvas) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
            setGestureName("Tangan tidak terdeteksi");
            lastDetectedGesture = null;
        }
    }

    animationFrameId = requestAnimationFrame(renderLoop);
}

if (startBtn) {
    startBtn.addEventListener("click", async () => {
        try {
            setStatus("Menyiapkan model...");

            if (!handLandmarker) {
                await initHandLandmarker();
            }

            setStatus("Mengakses kamera...");
            await startCamera();
        } catch (error) {
            console.error("Gesture login error:", error);
            setStatus(`Gagal: ${error?.message || error}`);
        }
    });
}

if (resetBtn) {
    resetBtn.addEventListener("click", () => {
        stopCamera();
    });
}

window.addEventListener("resize", () => {
    resizeCanvasToVideo();
});

setGestureName("Belum ada");
updateProgressUI();
setStatus("Menunggu kamera");