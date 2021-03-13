<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('signalling-start') }}" method="POST">
        @csrf
        <div>
            <label for="receiverClientId">Remote Client Id</label>
            <input type="text" name="receiverClientId" id="receiverClientId">
        </div>
        <button type="submit" id="submit" onclick="makeCall()">Submit</button>
    </form>
    <video id="localVideo" autoplay playsinline controls="false"/>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script>
        (async function playVideoFromCamera() {
            try {
                const constraints = {'video': true, 'audio': true};
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                const videoElement = document.querySelector('video#localVideo');
                videoElement.srcObject = stream;
            } catch(error) {
                console.error('Error opening video camera.', error);
            }
        })();

        async function makeCall() {
            event.preventDefault();

            const configuration = {'iceServers': [{'urls': 'stun:stun.l.google.com:19302'}]}
            const peerConnection = new RTCPeerConnection(configuration);
            // signalingChannel.addEventListener('message', async message => {
            //     if (message.answer) {
            //         const remoteDesc = new RTCSessionDescription(message.answer);
            //         await peerConnection.setRemoteDescription(remoteDesc);
            //     }
            // });
            Echo.channel('signalling-channel')
            .listen('.message', (e) => {
                console.log('event received');
                console.log(e);
            });
            const offer = await peerConnection.createOffer();
            await peerConnection.setLocalDescription(offer);
            // signalingChannel.send({'offer': offer});
            axios.post("{{ route('signalling-start') }}", {
                'message': offer,
                'receiverClientId': document.getElementById('receiverClientId').value
            })
            .catch(function (error) {
                console.log(error);
            });
        }

        Echo.channel('signalling-channel')
            .listen('.message', (e) => {
                console.log('event received');
                console.log(e);
            });
    </script>
</body>
</html>