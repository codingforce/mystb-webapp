<?php $this->load->view("partials/header") ?>
<div class="container-fluid">
    <div class="col-12 col-md-4 offset-md-4">
        <div class="row">
            <div class="col-6">
                <div style="font-size: 84px; text-align: center">
                    <?php if (!empty($recipient_logo)): ?>
                        <img class="img-fluid" src="<?= $recipient_logo ?>" alt="">
                    <?php else: ?>
                        <i class="far fa-building"></i>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-6">
                <h1 style="word-break: break-word"><?= $recipient_name ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="padding: 15px">
                <div class="col-12 p-0" style="min-height: 300px; border: 1px solid black">
                    <div id="screenshot" style="text-align:center; overflow: hidden">
                        <video class="videostream" style="width: 100%" autoplay></video>
                        <img data-rotate="0" id="screenshot-img" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 text-center">
                <a href="javascript:void(0)" class="capture-button" style="font-size: 48px; text-align: center">
                    <i class="fas fa-camera"></i>
                </a>
                <a href="javascript:void(0)" id="screenshot-button"
                   style="font-size: 48px; text-align: center; display: none">
                    <i class="fas fa-save"></i>
                </a>
            </div>
            <div class="col-6 text-center">
                <a href="#" style="font-size: 48px" id="rotate-button">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-block" role="button" href="javascript:void(0)" onclick="sendMail()">
                    <i id="spinner" class="fa fa-spinner fa-spin" style="display: none"></i><i id="send"
                                                                                               class="far fa-paper-plane"></i>&nbsp;Dokument
                    senden
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center mt-5">
                <p>bereitgestellt von</p>
                <a class="text-underline" href="<?= $recipient_web ?>"><?= $recipient_web ?></a>
            </div>
        </div>
    </div>
</div>
<form id="stbform">
    <input type="hidden" name="capture-img" id="captureImg" value="">
    <input type="hidden" name="recipient-email" value="<?= $recipient_email ?>">
</form>
<script>
    function handleError(error) {
        console.error('navigator.getUserMedia error: ', error);
    }

    const constraints = {video: true};

    (function () {
        const captureVideoButton =
            document.querySelector('.capture-button');
        const screenshotButton = document.querySelector('#screenshot-button');
        const rotateButton = document.querySelector('#rotate-button');
        const img = document.querySelector('#screenshot img');
        const video = document.querySelector('#screenshot video');

        const canvas = document.createElement('canvas');

        video.setAttribute('autoplay', '');
        video.setAttribute('muted', '');
        video.setAttribute('playsinline', '');


        captureVideoButton.onclick = function () {
            navigator.mediaDevices.getUserMedia(constraints).then(handleSuccess).catch(handleError);
            captureVideoButton.style.display = "none";
            screenshotButton.style.display = "block";
            video.style.display = "block";
            img.setAttribute("src", "");
        };

        screenshotButton.onclick = video.onclick = function () {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            // Other browsers will fall back to image/png
            img.src = canvas.toDataURL('image/png');
            $('#captureImg').val(img.src);
            video.pause();
            document.getElementsByClassName('videostream')[0].style.display = 'none';
            if (video.srcObject != null) {
                video.srcObject.getTracks().map(function (val) {
                    val.stop();
                });
            }
            captureVideoButton.style.display = "block";
            screenshotButton.style.display = "none";
        };

        rotateButton.onclick = function () {
            var rotateVal = img.getAttribute('data-rotate') * 1;
            rotateVal += 90;
            img.setAttribute('style', 'transform:rotate(' + rotateVal + 'deg); width: 100%; height: 100%');
            img.setAttribute('data-rotate', rotateVal);
        };

        function handleSuccess(stream) {
            screenshotButton.disabled = false;
            video.srcObject = stream;
        }
    })();

</script>
<?php $this->load->view("partials/footer") ?>

