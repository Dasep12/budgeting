<table class="table">
    <thead>
        <th>Jenis Transaksi</th>
        <th>Particullar</th>
        <th>Ammmount</th>
        <th>Request By</th>
        <th>Keterangan</th>
        <th>Lampiran</th>
    </thead>
    <tbody>
        <?php foreach ($raimbus->result() as $rm) : ?>
            <tr>
                <td><?= $jenis ?></td>
                <td><?= $rm->particullar ?></td>
                <td><?= 'Rp. ' . number_format($rm->ammount, 0, ",", ".") ?></td>
                <td><?= $nama ?></td>
                <td><?= $remarks ?></td>
                <td>
                    <?php if ($file1 != NULL || $file1 != "") {
                        echo "<a target='_blank' href='" . base_url('assets/lampiran/' . $file1) . "' class='btn btn-outline btn-sm btn-primary'><span class='micon bi bi-image'></span></a>";
                    }  ?>

                    <?php if ($file2 != NULL || $file2 != "") {
                        echo "<a target='_blank' href='" . base_url('assets/lampiran/' . $file2) . "' class='btn btn-outline btn-sm btn-primary'><span class='micon bi bi-image'></span></a>";
                    }  ?>

                    <?php if ($file3 != NULL || $file3 != "") {
                        echo "<a target='_blank' href='" . base_url('assets/lampiran/' . $file3) . "' class='btn btn-outline btn-sm btn-primary'><span class='micon bi bi-image'></span></a>";
                    }  ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
    function open(link) {
        alert(link.toString())
    }
</script>