@extends('layouts.layout')

@section('content')
    <h1>Record Audio</h1>


    <h1>Record Pronunciation for: {{ $word->word }}</h1>

    <p><strong>Definition:</strong> {{ $word->definition }}</p>
    <p><strong>Part of Speech:</strong> {{ $word->part_of_speech }}</p>

    @if($word->recording_path)
        <div>
            <h3>Current Recording:</h3>
            <audio controls src="{{ Storage::url($word->recording_path) }}"></audio>
        </div>
    @endif

    <hr>

    <div id="message"></div>

    <button id="startRecord" type="button">Start Recording</button>
    <button id="stopRecord" type="button" disabled>Stop Recording</button>
    <button id="saveRecord" type="button" disabled>Save Recording</button>

    <p id="status">Ready</p>

    <div id="audioPlayback"></div>

    {{-- <a href="{{ route('word.details', $word->id) }}">Back to Word</a> --}}

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
