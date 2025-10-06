@extends('layouts.layout')

@section('content')
<div class="container my-5">
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
            <h4 class="mb-0">
                <i class="bi bi-mic-fill me-2"></i> Record Pronunciation
            </h4>
        </div>

        <div class="card-body">
            {{-- Word Info --}}
            <div class="mb-4">
                <h5 class="text-dark">
                    <span class="text-muted">Word:</span> 
                    <strong class="text-success">{{ $word->word }}</strong>
                </h5>
                <p><strong class="text-muted">Definition:</strong> {{ $word->definition }}</p>
                <p>
                    <strong class="text-muted">Part of Speech:</strong> 
                    <span class="badge bg-success text-white text-capitalize px-3 py-1">
                        {{ $word->part_of_speech }}
                    </span>
                </p>
            </div>

            
            {{-- Existing Recording --}}
            @if($word->recording_path)
                <hr>
                <div class="mb-4">
                    <label class="form-label text-muted fw-semibold">🎧 Existing Recording:</label>
                    <div class="border rounded p-2 bg-light">
                        <audio controls class="w-100">
                            <source src="{{ Storage::url($word->recording_path) }}" type="audio/webm">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
            @endif

            <hr>

            {{-- Status --}}
            <div class="mb-3 ">
                <div id="status" class="badge bg-success-subtle text-success px-3 py-2">Ready 
                </div>
                <div id="timer" class="badge bg-light-subtle text-danger px-3 py-2">00:00:00</div>
            </div>
            

            {{-- WAVEFORM CANVAS --}}
            <canvas id="waveform" width="350" height="80" class="mb-3 rounded"></canvas>

            {{-- Recorder Controls --}}
            <div class="d-flex flex-wrap gap-3 mb-4">
                <button id="startRecord" class="btn btn-success d-flex align-items-center">
                    🎙️ <span id="recordText" class="ms-2">Start Recording</span>
                </button>
                <button id="stopRecord" class="btn btn-warning text-white d-flex align-items-center" disabled>
                    ⏹️ <span class="ms-2">Stop</span>
                </button>
                <button id="saveRecord" class="btn btn-primary d-flex align-items-center" disabled>
                    💾 <span class="ms-2">Save</span>
                </button>
            </div>

            {{-- Playback of New Recording --}}
            <div>
                <label class="form-label text-muted fw-semibold">🎬 Recording Preview:</label>
                <div id="audioPlayback" class="mt-3"></div>
            </div>

            {{-- Back Button --}}
            <div class="mt-5">
                <a href="{{ route('manage', ['search' => $word->word]) }}" 
                   class="btn btn-outline-success rounded-pill px-4 py-2">
                    ← Back to Manage
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
<style>
    button:enabled:hover {
        transform: scale(1.03);
        transition: transform 0.2s ease-in-out;
    }
    #waveform {
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
    }
    
</style>

{{-- Recorder + Visualizer Script --}}
<script>
       let mediaRecorder, audioChunks = [], audioBlob;
    let analyser, dataArray, canvasCtx, animationId;
    let audioContext, source;
    let timerInterval, startTime;

    const startButton = document.getElementById('startRecord');
    const stopButton = document.getElementById('stopRecord');
    const saveButton = document.getElementById('saveRecord');
    const statusDiv = document.getElementById('status');
    const messageDiv = document.getElementById('message');
    const audioPlayback = document.getElementById('audioPlayback');
    const timerDisplay = document.getElementById('timer');

    const canvas = document.getElementById('waveform');
    canvasCtx = canvas.getContext('2d');

    const hasExistingRecording = @json(!empty($word->recording_path));
    if (hasExistingRecording) {
        document.getElementById('recordText').textContent = 'Re-record';
    }

    function formatTimeWithMs(milliseconds) {
        const totalSeconds = Math.floor(milliseconds / 1000);
        const mins = Math.floor(totalSeconds / 60).toString().padStart(2, '0');
        const secs = (totalSeconds % 60).toString().padStart(2, '0');
        const ms = Math.floor((milliseconds % 1000) / 10).toString().padStart(2, '0'); // two digits
        return `${mins}:${secs}:${ms}`;
    }

    function startTimer() {
        startTime = Date.now();
        timerDisplay.textContent = "00:00:00";
        timerInterval = setInterval(() => {
            const elapsed = Date.now() - startTime;
            timerDisplay.textContent = formatTimeWithMs(elapsed);
        }, 50);
    }

    function stopTimer() {
        clearInterval(timerInterval);
        timerDisplay.textContent = "00:00:00";
    }


    startButton.addEventListener('click', async (e) => {
        e.preventDefault();
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            
            // Start timer only after successful stream access
            startTimer();

            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];

            mediaRecorder.ondataavailable = (event) => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                const audioUrl = URL.createObjectURL(audioBlob);
                audioPlayback.innerHTML = `
                    <div class="border rounded bg-light p-2 mt-2">
                        <audio controls class="w-100">
                            <source src="${audioUrl}" type="audio/webm">
                        </audio>
                    </div>`;
                saveButton.disabled = false;
                statusDiv.textContent = 'Recording stopped';
            };

            // Setup AudioContext for analyzer
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

                canvasCtx.fillStyle = '#f8f9fa';
                canvasCtx.fillRect(0, 0, canvas.width, canvas.height);

                canvasCtx.lineWidth = 2;
                canvasCtx.strokeStyle = '#198754'; // Bootstrap success green
                canvasCtx.beginPath();

                const sliceWidth = canvas.width * 1.0 / bufferLength;
                let x = 0;

                for (let i = 0; i < bufferLength; i++) {
                    const v = dataArray[i] / 128.0;
                    const y = v * canvas.height / 2;

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

            mediaRecorder.start();
            startButton.disabled = true;
            stopButton.disabled = false;
            saveButton.disabled = true;
            statusDiv.textContent = 'Recording...';

        } catch (error) {
            statusDiv.textContent = '❌ Error accessing microphone.';
        }
    });

    stopButton.addEventListener('click', () => {
        if (mediaRecorder && mediaRecorder.state !== "inactive") {
            mediaRecorder.stop();
            mediaRecorder.stream.getTracks().forEach(track => track.stop());
        }
        startButton.disabled = false;
        stopButton.disabled = true;

        stopTimer();

        // Stop visualizer
        cancelAnimationFrame(animationId);
        if (audioContext) audioContext.close();
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
