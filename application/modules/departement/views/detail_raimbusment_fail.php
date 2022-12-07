<table class="table">
    <thead>
        <th>Particullar</th>
        <th>Ammount</th>
    </thead>
    <tbody>
        <?php foreach ($raimbus->result() as $rm) : ?>
            <tr>
                <td><?= $rm->particullar ?></td>
                <td><?= 'Rp. ' . number_format($rm->ammount, 0, ",", ".") ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>