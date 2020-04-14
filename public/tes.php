<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "db_seleksilokal");
$column = array("prodi.idprodi", "prodi.namaprodi");
$query = "SELECT * FROM prodi";
$query .= " WHERE ";
if(isset($_POST["is_category"]))
{
 $query .= "prodi.namaprodi = '".$_POST["is_category"]."' AND ";
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(prodi.namaprodi LIKE "%'.$_POST["search"]["value"].'%")';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY prodi.namaprodi DESC ';
}

$query1 = '';

if($_POST["length"] != 1)
{
 $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["idprodi"];
 $sub_array[] = $row["namaprodi"];
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM prodi";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>
