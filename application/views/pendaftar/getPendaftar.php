<font color="orange">
</font>
<table border="1">
    <?php
    foreach ($datapendaftar as $pendaftar){
        echo "<tr>
              <td>$pendaftar->username</td>
              <td>".strtoupper($pendaftar->namalengkap)."</td>
              <td>".strtoupper($pendaftar->lokasi_tempatlahir)."</td>
              <td>$pendaftar->tgl_lahir</td>
              <td>$pendaftar->jeniskelamin</td>
              <td>$pendaftar->suku</td>
              <td>$pendaftar->pilihan1</td>
              <td>$pendaftar->pilihan2</td>
              <td>$pendaftar->pilihan3</td>
              <td>$pendaftar->jenissmta</td>
              <td>$pendaftar->jurusansmta</td>
              <td>$pendaftar->tahunlulus_smta</td>
              <td>".strtoupper($pendaftar->namasmta)."</td>
              <td>$pendaftar->nrapor1</td>
              <td>$pendaftar->nrapor2</td>
              <td>$pendaftar->nrapor3</td>
              <td>$pendaftar->tahunakademik</td>
              
              </tr>";
    }
    ?>
</table>