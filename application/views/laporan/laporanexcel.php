<?php 
 header("Content-type: application/vnd-ms-excel");
 header("Content-Disposition: attachment; filename=$title.xls");
 header("Pragma: no-cache");
 header("Expires: 0"); 
 ?>
 <table border="0" width="100%" style="font-size:19;font-weight:bold;">
    <tr><th colspan="8"><?php echo $title;?></th></tr>
    <tr><td></td></tr>
 </table>
 <table border="1" width="100%">
      <thead>
           <tr height="40" bgcolor="gray">
                <th>No</th>
                <th>No. Peserta</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Jenjang</th>
                <th>Fakultas</th>
                <th>Suku</th>
                <th>Asal SLTA</th>
           </tr>
      </thead>
      <tbody>
           <?php $i=1; foreach($list as $row) { ?>
           <tr height="20">
                <td><?php echo $i; ?></td>
                <td><?php echo $row->nopendaftar; ?></td>
                <td><?php echo $row->namapendaftar; ?></td>
                <td><?php echo $row->namaprodi; ?></td>
                <td><?php echo $row->jenjang; ?></td>
                <td><?php echo $row->namafakultas; ?></td>
                <td><?php echo $row->suku ?></td>
                <td><?php echo $row->asalslta; ?></td>
           </tr>
           <?php $i++; } ?>
      </tbody>
 </table>