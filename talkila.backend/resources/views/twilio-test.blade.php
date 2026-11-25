<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Twilio Room Tester</title>
    <style>
        body { font-family: system-ui, sans-serif; padding: 2rem; background: #f7fafc; }
        .container { max-width: 600px; margin: 0 auto; }
        h1 { font-size: 1.5rem; margin-bottom: 1.5rem; }
        .field { margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem; }
        .field label { width: 140px; font-weight: 600; text-align: right; }
        .field input, .field select { flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 24px; background: #3182ce; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        button:disabled { background: #a0aec0; cursor: wait; }
        #response { margin-top: 1rem; padding: 1rem; background: #edf2f7; border-radius: 4px; white-space: pre-wrap; word-break: break-all; display: none; }
        .group-fields { display: none; }
        .group-fields.show { display: block; }
        hr { margin: 1.5rem 0; border: none; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Twilio Room Tester</h1>

        <div class="field">
            <label>Room Name</label>
            <input type="text" id="room_name" value="test_room">
        </div>
        <div class="field">
            <label>Type</label>
            <select id="type" onchange="toggleGroup()">
                <option value="video_one_to_one">Video One To One</option>
                <option value="video_one_to_many">Video One To Many</option>
                <option value="audio_one_to_one">Audio One To One</option>
                <option value="audio_one_to_many">Audio One To Many</option>
            </select>
        </div>
        <div class="field">
            <label>Pointer</label>
            <input type="text" id="pointer">
        </div>
        <div class="field">
            <label>Duration</label>
            <input type="number" id="duration" value="15">
        </div>

        <hr>
        <h3>Host</h3>
        <div class="field">
            <label>User ID</label>
            <input type="text" id="host_id" value="">
        </div>
        <div class="field">
            <label>Token</label>
            <input type="text" id="host_token" value="">
        </div>
        <div class="field">
            <label>Number</label>
            <input type="text" id="host_number" value="">
        </div>

        <hr>
        <h3>Attendee 1</h3>
        <div class="field">
            <label>User ID</label>
            <input type="text" id="att1_id" value="">
        </div>
        <div class="field">
            <label>Token</label>
            <input type="text" id="att1_token" value="">
        </div>
        <div class="field">
            <label>Number</label>
            <input type="text" id="att1_number" value="">
        </div>

        <div id="groupFields" class="group-fields">
            <hr>
            <h3>Attendee 2</h3>
            <div class="field">
                <label>User ID</label>
                <input type="text" id="att2_id">
            </div>
            <div class="field">
                <label>Token</label>
                <input type="text" id="att2_token">
            </div>
            <div class="field">
                <label>Number</label>
                <input type="text" id="att2_number">
            </div>

            <hr>
            <h3>Attendee 3</h3>
            <div class="field">
                <label>User ID</label>
                <input type="text" id="att3_id">
            </div>
            <div class="field">
                <label>Token</label>
                <input type="text" id="att3_token">
            </div>
            <div class="field">
                <label>Number</label>
                <input type="text" id="att3_number">
            </div>

            <hr>
            <h3>Attendee 4</h3>
            <div class="field">
                <label>User ID</label>
                <input type="text" id="att4_id">
            </div>
            <div class="field">
                <label>Token</label>
                <input type="text" id="att4_token">
            </div>
            <div class="field">
                <label>Number</label>
                <input type="text" id="att4_number">
            </div>
        </div>

        <hr>
        <div class="field">
            <label></label>
            <button id="submitBtn" onclick="submit()">Create Room</button>
        </div>
        <div id="response"></div>
    </div>

    <script>
        function toggleGroup() {
            var type = document.getElementById('type').value;
            var group = document.getElementById('groupFields');
            group.className = type.includes('many') ? 'group-fields show' : 'group-fields';
        }

        function val(id) { return document.getElementById(id).value; }

        function submit() {
            var btn = document.getElementById('submitBtn');
            var resp = document.getElementById('response');
            btn.disabled = true;
            btn.textContent = 'Processing...';

            var type = val('type');
            var fields = {
                pointer: val('pointer'),
                room_name: val('room_name'),
                talk_type: type.split('_')[0] === 'video' ? 2 : 1,
                call_type: type.split('_')[3] === 'many' ? 2 : 1,
                duration: val('duration'),
                host: { token: val('host_token'), user_id: val('host_id'), mobile_number: val('host_number') },
                attendees: [{ token: val('att1_token'), user_id: val('att1_id'), mobile_number: val('att1_number') }],
                action: window.location.pathname.includes('ali') ? 1 : 2
            };

            if (type.includes('many')) {
                fields.attendees.push({ token: val('att2_token'), user_id: val('att2_id'), mobile_number: val('att2_number') });
                fields.attendees.push({ token: val('att3_token'), user_id: val('att3_id'), mobile_number: val('att3_number') });
                fields.attendees.push({ token: val('att4_token'), user_id: val('att4_id'), mobile_number: val('att4_number') });
            }

            fetch('/api/test', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(fields)
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                resp.style.display = 'block';
                resp.textContent = JSON.stringify(data, null, 2);
                btn.disabled = false;
                btn.textContent = 'Create Room';
            })
            .catch(function(err) {
                resp.style.display = 'block';
                resp.textContent = 'Error: ' + err.message;
                btn.disabled = false;
                btn.textContent = 'Create Room';
            });
        }
    </script>
</body>
</html>
