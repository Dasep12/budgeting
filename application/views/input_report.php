<div class="row mt-2 ">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <form action="/action_page.php">
                    <p>Pilih Kondisi :</p>
                    <label for="normal">Normal</label>
                    <input type="radio" class="radio" id="normal" name="kondisi" value="0"><br>
                    <label for="abnormal">Tidak Normal</label>
                    <input type="radio" class="radio" id="abnormal" name="kondisi" value="1">
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('radio').click(function() {
            alert("tes")
        })
    })
</script>