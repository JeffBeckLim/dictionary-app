@extends('layouts.layout')

@section('content')
<div class="container my-5 d-flex justify-content-center">
    <div class="card shadow border-0 p-4" style="max-width: 400px; width: 100%;">
        <div class="text-center mb-4">
            <h4 class="mb-0 fw-bold text-success">{{ $word->word }}</h4>
            <small class="text-muted">{{ $word->definition }}</small>
        </div>

        {{-- Existing Recording --}}
        @if($word->recording_path)
        <div class="mb-3 text-center">
            <audio controls style="width: 100%;">
                <source src="{{ Storage::url($word->recording_path) }}" type="audio/webm">
                Your browser does not support the audio element.
            </audio>
            <small class="text-muted d-block mt-1">Existing Recording</small>
        </div>
        @endif

        <hr>

        {{-- Waveform Canvas --}}
        <canvas id="waveform" width="350" height="80" class="mb-3 rounded"></canvas>

        {{-- Timer --}}
        <div id="timer" class="text-center mb-3 fs-5 text-danger fw-bold" style="letter-spacing: 2px;">00:00</div>

        {{-- Controls --}}
        <div class="d-flex justify-content-center gap-4 mb-3">
            <button id="startRecord" class="btn btn-danger rounded-circle record-btn" title="Start Recording" aria-label="Start Recording">
                <span></span>
            </button>

            <button id="stopRecord" class="btn btn-secondary rounded-circle stop-btn" disabled title="Stop Recording" aria-label="Stop Recording">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-stop-fill" viewBox="0 0 16 16">
                    <rect width="16" height="16" rx="2" ry="2"/>
                </svg>
            </button>

            <button id="saveRecord" class="btn btn-primary rounded-pill px-4 fw-bold" disabled>Save</button>
        </div>

        <div id="status" class="text-center text-muted small mb-2">Ready to record</div>

        {{-- Preview --}}
        <div id="audioPlayback" class="mt-3"></div>
    </div>
</div>

{{-- Custom CSS --}}
<style>
    /* Big red circular record button */
    .record-btn {
        width: 70px;
        height: 70px;
        background-color: #ff3b30;
        border: none;
        position: relative;
        box-shadow: 0 0 15px rgba(255, 59, 48, 0.5);
        transition: box-shadow 0.3s ease;
        cursor: pointer;
    }
    .record-btn span {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        transition: background 0.3s ease;
    }
    .record-btn:active {
        box-shadow: 0 0 30px rgba(255, 59, 48, 0.8);
    }
    .record-btn:active span {
        background: #ff3b30;
    }

    /* Stop button */
    .stop-btn {
        width: 50px;
        height: 50px;
        border: none;
        background-color: #6c757d;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }
    .stop-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .stop-btn:hover:not(:disabled) {
        background-color: #5a6268;
    }

    /* Save button */
    #saveRecord {
        height: 50px;
        font-size: 1rem;
        cursor: pointer;
    }
    #saveRecord:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Waveform canvas styling */
    #waveform {
        background: #f9f9f9;
        border: 1px solid #ddd;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
    }

    /* Timer */
    #timer {
        font-family: 'SF Pro Text', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen,
            Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        letter-spacing: 2px;
        user-select: none;
    }
</style>

{{-- Recorder + Visualizer + Timer Script --}}
<script>
    let mediaRecorder, audioChunks = [], audioBlob;
    let analyser, dataArray, canvasCtx, animationId;
    let audioContext, source;
    let startTime, timerInterval;

    const startButton = document.getElementById('startRecord');
    const stopButton = document.getElementById('stopRecord');
    const saveButton = document.getElementById('saveRecord');
    const statusDiv = document.getElementById('status');
    const audioPlayback = document.getElementById('audioPlayback');
    const timerDisplay = document.getElementById('timer');

    const canvas = document.getElementById('waveform');
    canvasCtx = canvas.getContext('2d');

    const hasExistingRecording = @json(!empty($word->recording_path));
    if (hasExistingRecording) {
        // Change UI text or state if needed, for iPhone style just keep record button red
    }

    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60).toString().padStart(2, '0');
        const secs = (seconds % 60).toString().padStart(2, '0');
        return `${mins}:${secs}`;
    }

    function startTimer() {
        startTime = Date.now();
        timerDisplay.textContent = "00:00";
        timerInterval = setInterval(() => {
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            timerDisplay.textContent = formatTime(elapsed);
        }, 500);
    }

    function stopTimer() {
        clearInterval(timerInterval);
        timerDisplay.textContent = "00:00";
    }

    startButton.addEventListener('click', async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];

            mediaRecorder.ondataavailable = event => audioChunks.push(event.data);

            mediaRecorder.onstop = () => {
                audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                const audioUrl = URL.createObjectURL(audioBlob);
                audioPlayback.innerHTML = `
                    <audio controls style="width:100%" src="${audioUrl}"></audio>
                `;
                saveButton.disabled = false;
                statusDiv.textContent = 'Recording stopped';
            };

            // Setup AudioContext and analyzer for waveform
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
            source = audioContext.createMediaStreamSource(stream);
            analyser = audioContext.createAnalyser();
            analyser.fftSize = 2048;
            const bufferLength = analyser.frequencyBinCount;
            dataArray = new Uint8Array(bufferLength);
            source.connect(analyser);

            function drawWaveform() {
                animationId = requestAnimationFrame(drawWaveform);
                analyser.getByteTimeDomainData(dataArray);

                canvasCtx.fillStyle = '#f9f9f9';
                canvasCtx.fillRect(0, 0, canvas.width, canvas.height);

                canvasCtx.lineWidth = 2;
                canvasCtx.strokeStyle = '#ff3b30'; // iPhone red
                canvasCtx.beginPath();

                let sliceWidth = canvas.width / bufferLength;
                let x = 0;

                for (let i = 0; i < bufferLength; i++) {
                    let v = dataArray[i] / 128.0;
                    let y = v * canvas.height / 2;
                    if (i === 0) {
                        canvasCtx.moveTo(x, y);
                    } else {
                        canvasCtx.lineTo(x, y);
                    }
                    x += sliceWidth;
                }
                canvasCtx.lineTo(canvas.width, canvas.height / 2);
                canvasCtx.stroke();
            }

            drawWaveform();
            startTimer();

            mediaRecorder.start();
            startButton.disabled = true;
            stopButton.disabled = false;
            saveButton.disabled = true;
            statusDiv.textContent = 'Recording...';
        } catch (e) {
            statusDiv.textContent = '❌ Error accessing microphone.';
        }
    });

    stopButton.addEventListener('click', () => {
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
            mediaRecorder.stream.getTracks().forEach(track => track.stop());
        }
        startButton.disabled = false;
        stopButton.disabled = true;
        saveButton.disabled = false;
        statusDiv.textContent = 'Recording stopped';
        cancelAnimationFrame(animationId);
        if (audioContext) audioContext.close();
        stopTimer();
    });

    saveButton.addEventListener('click', () => {
        const hasRecording = @json(!empty($word->recording_path));
        showConfirmationModal({
            title: 'Confirm Save',
            message: hasRecording
                ? 'This word already has a recording. Saving will replace the existing one. Do you want to proceed?'
                : 'Do you want to save this new recording?',
            confirmButtonText: 'Yes, Save',
            onConfirm: saveRecording
        });
    });

    async function saveRecording() {
        const formData = new FormData();
        formData.append('audio', audioBlob, 'recording.webm');

        try {
            saveButton.disabled = true;
            statusDiv.textContent = 'Saving...';

            const response = await fetch('{{ route("word.save.recording", $word->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                statusDiv.textContent = '✅ Saved!';
                setTimeout(() => location.reload(), 2000);
            } else {
                statusDiv.textContent = '❌ Error saving recording.';
                saveButton.disabled = false;
            }
        } catch (error) {
            statusDiv.textContent = '❌ Save failed: ' + error.message;
            saveButton.disabled = false;
        }
    }
</script>
@endsection
