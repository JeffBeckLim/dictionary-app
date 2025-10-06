@extends('layouts.layout')

@section('content')
<div class="container my-5">
    <div class="card border-success shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Record Pronunciation</h4>
        </div>
        <div class="card-body">

            <h5 class="text-success">Word: <strong>{{ $word->word }}</strong></h5>

            <p class="mb-1"><strong>Definition:</strong> {{ $word->definition }}</p>
            <p class="mb-3"><strong>Part of Speech:</strong> 
                <span class="badge bg-success-subtle text-success text-capitalize">
                    {{ $word->part_of_speech }}
                </span>
            </p>

            @if($word->recording_path)
                <div class="mb-4">
                    <h6>Current Recording:</h6>
                    <audio controls class="w-100">
                        <source src="{{ Storage::url($word->recording_path) }}" type="audio/webm">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            @endif

            <hr>

            <div id="message" class="mb-3 text-danger fw-semibold"></div>

            <div class="mb-3 d-flex flex-wrap gap-2">
                <button id="startRecord" class="btn btn-outline-success">
                    🎙️ Start Recording
                </button>
                <button id="stopRecord" class="btn btn-outline-warning" disabled>
                    ⏹️ Stop
                </button>
                <button id="saveRecord" class="btn btn-outline-primary" disabled>
                    💾 Save
                </button>
            </div>

            <p id="status" class="form-text text-muted">Ready</p>

            <div id="audioPlayback" class="mt-3"></div>

            <!-- <a href="{{ route('word.details', $word->id) }}" class="btn btn-link mt-4">← Back to Word</a> -->
            <a href="{{ route('manage', ['search' => $word->word]) }}" 
            class="btn btn-sm btn-outline-success mt-4">
                <!-- ← Back to Manage (Search: "{{ $word->word }}") -->
                ← Back to Manage
            </a>


        </div>
    </div>
</div>

{{-- Optional Hover Effects --}}
<style>
    button:enabled:hover {
        transform: scale(1.05);
        transition: 0.2s ease;
    }
</style>

    <!-- {{-- <a href="{{ route('word.details', $word->id) }}">Back to Word</a> --}} -->

    <script>
        let mediaRecorder;
        let audioChunks = [];
        let audioBlob;

        const startButton = document.getElementById('startRecord');
        const stopButton = document.getElementById('stopRecord');
        const saveButton = document.getElementById('saveRecord');
        const statusDiv = document.getElementById('status');
        const messageDiv = document.getElementById('message');
        const audioPlayback = document.getElementById('audioPlayback');

        startButton.addEventListener('click', async (e) => {
            e.preventDefault();
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = (event) => {
                    audioChunks.push(event.data);
                };

                mediaRecorder.onstop = () => {
                    audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    
                    audioPlayback.innerHTML = '<audio controls src="' + audioUrl + '"></audio>';
                    
                    saveButton.disabled = false;
                    statusDiv.textContent = 'Recording stopped';
                };

                mediaRecorder.start();
                
                startButton.disabled = true;
                stopButton.disabled = false;
                saveButton.disabled = true;
                statusDiv.textContent = 'Recording...';
                messageDiv.textContent = 'Recording started';

            } catch (error) {
                messageDiv.textContent = 'Error: Could not access microphone';
            }
        });

        stopButton.addEventListener('click', () => {
            mediaRecorder.stop();
            mediaRecorder.stream.getTracks().forEach(track => track.stop());
            
            startButton.disabled = false;
            stopButton.disabled = true;
        });

        saveButton.addEventListener('click', async () => {
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
                console.log(data);

                if (data.success) {
                    messageDiv.textContent = 'Recording saved successfully!';
                    statusDiv.textContent = 'Saved';
                    
                    // Reload page after 2 seconds to show new recording
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    messageDiv.textContent = 'Error saving recording';
                    saveButton.disabled = false;
                }

            } catch (error) {
                console.log(error);
                console.error("Error details:", error);
                console.error("Stack trace:", error.stack);
                messageDiv.textContent = 'Error saving recording' + error.message;
                saveButton.disabled = false;
            }
        });
    </script>
@endsection
