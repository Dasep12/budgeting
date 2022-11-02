<div class="row justify-content-center">
    <div class="card">
        <div class="card-body">
            <span>anda sedang berada di lokasi:<br>Area Patroli Gate 1</span>
            <video width="400" class="img-thumbnail" id="preview" playsinline></video>
            <div class="alert alert-danger">
                <span>arahkan kamera pada barcode</span>
            </div>
        </div>
    </div>
</div>



<script>
    Instascan.Camera.getCameras().then(function(cameras) {
        console.log(cameras.length);
        var totalCamera = cameras.length;
        if (cameras.length > 0) {
            var selectedCam = cameras[0];
            // $.each(cameras, (i, c) => {
            //     if (c.name.indexOf('back') != -1) {
            //         selectedCam = c;
            //         return false;
            //     }
            // });
            scanner.start(selectedCam);

        } else {
            console.error('No cameras found.');
        }

    }).catch(function(e) {
        console.error(e);
    });

    //tampilkan camera untuk scan barcode
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview'),
        mirror: false,
        scanPeriod: 5,
    });

    scanner.addListener('scan', function(content) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const long = position.coords.longitude;
        });
        console.log(content)
    });
</script>