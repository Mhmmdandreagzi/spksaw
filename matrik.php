<!DOCTYPE html>
<html lang="en">
<?php
require "layout/head.php";
require "include/conn.php";

$q_alternative = "SELECT * FROM saw_alternatives";
$rs_alternative = $db->query($q_alternative);
$rows_alternative = $rs_alternative->num_rows;
$alternatives = [];
while ($row = $rs_alternative->fetch_object()) {
    $alternatives[$row->id_alternative] = $row->name;
}


$q_criteria = "SELECT * FROM saw_criterias";
$rs_criteria = $db->query($q_criteria);
$rows_criteria = $rs_criteria->num_rows;
$criteria = [];
while($row = $rs_criteria->fetch_object()) {
    $criteria[$row->id_criteria] = $row->criteria;
}
?>

<body>
    <div id="app">
        <?php require "layout/sidebar.php"; ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3>Matrik</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Matriks Keputusan (X) &amp; Ternormalisasi (R)</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <p class="card-text">Melakukan perhitungan normalisasi untuk mendapatkan matriks nilai ternormalisasi (R), dengan ketentuan :
                                        Untuk normalisai nilai, jika faktor/attribute kriteria bertipe cost maka digunakan rumusan:
                                        Rij = ( min{Xij} / Xij)
                                        sedangkan jika faktor/attribute kriteria bertipe benefit maka digunakan rumusan:
                                        Rij = ( Xij/max{Xij} )</p>

                                    <button type="button" class="btn btn-outline-success btn-sm m-2" data-bs-toggle="modal"
                                        data-bs-target="#inlineForm">
                                        Isi Nilai Alternatif
                                    </button>

                                    <div>
                                        <caption>
                                            Matrik Keputusan(X)
                                        </caption>
                                        <br>
                                        <br>
                                        <table class="table table-bordered mb-0">
                                            <tr>
                                                <th rowspan='2' style="text-align: center; vertical-align: middle; width: 10%;">Kode</th>
                                                <th rowspan='2' style="text-align: center; vertical-align: middle; width: 30%;">Alternatif</th>
                                                <th colspan='<?php echo $rows_alternative ?>' style="width: 60%; text-align: center;">Kriteria</th>
                                            </tr>
                                            <tr>
                                                <?php
                                                    $in = 1;
                                                    foreach ($criteria as $id => $row) {
                                                        echo "<th>(C<sub>{$in}</sub>) {$row}</th>";
                                                        $in++;
                                                    }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                $i = 1;
                                                foreach ($alternatives as $id_alternatives => $row) {
                                                    echo "<tr>";
                                                    echo "<th style='text-align: center;'>A<sub>{$i}</sub></th>";
                                                    echo "<th>{$row}</th>";
                                                    foreach ($criteria as $id_criteria => $row) {
                                                        echo "<td><input type='number' class='form-control nilai_alternative' data-id_alternative='{$id_alternatives}' data-id_criteria='{$id_criteria}'></td>";
                                                    }
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                                ?>
                                            </tr>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-primary m-2 form-control" id="btn-normalisasi">Hitung Normalisasi</button>
                                    <!-- Matrik Keputusan -->
                                    <div>
                                        <hr>
                                        <caption>
                                            Matrik Ternormalisasi (R)
                                        </caption>
                                        <br>
                                        <br>
                                        <table class="table table-striped mb-0">
                                            <tr>
                                                <th rowspan='2'>Alternatif</th>
                                                <th colspan='5'>Kriteria</th>
                                            </tr>
                                            <tr>
                                                <th>C1</th>
                                                <th>C2</th>
                                                <th>C3</th>
                                                <th>C4</th>
                                                <th>C5</th>
                                            </tr>

                                        </table>
                                    </div>
                                    <!-- Matrik Ternormalisasi -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php require "layout/footer.php"; ?>
        </div>
    </div>
    <?php require "layout/js.php"; ?>

</body>
<script>
    $(document).ready(function() {
        $("#btn-normalisasi").click(function() {
            let data = $(".nilai_alternative");

            data.each(function(i,e) {
                console.log(e.val());
            })
            
        });
    });
</script>
</html>