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
    array_push($alternatives, array(
        'id' => $row->id_alternative,
        'name' => $row->name
    ));
}

$q_criteria = "SELECT * FROM saw_criterias";
$rs_criteria = $db->query($q_criteria);
$rows_criteria = $rs_criteria->num_rows;
$criteria = [];

while($row = $rs_criteria->fetch_object()) {
    array_push($criteria, array(
        'id' => $row->id_criteria,
        'name' => $row->criteria,
        'weight' => $row->weight,
        'attribute' => $row->attribute
    ));
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
                                                        echo "<th>(C<sub>{$in}</sub>) {$row['name']}</th>";
                                                        $in++;
                                                    }
                                                ?>
                                            </tr>
                                            <tr>
                                                <?php
                                                $i = 1;
                                                foreach ($alternatives as $id_alternatives => $alternative_row) {
                                                    echo "<tr>";
                                                    echo "<th style='text-align: center;'>A<sub>{$i}</sub></th>";
                                                    echo "<th>{$alternative_row['name']}</th>";
                                                    foreach ($criteria as $id_criteria => $criteria_row) {
                                                        echo "<td><input type='number' class='form-control nilai_alternative' data-id_alternative='{$alternative_row['id']}' data-id_criteria='{$criteria_row['id']}' value='{$i}'></td>";
                                                    }
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                                ?>
                                            </tr>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-primary m-2 form-control" id="btn-normalisasi">Hitung Normalisasi</button>
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
            let belumIsi = []
            data.each(function(i,e) {
                if($(e).val() && $(e).val() != 0){
                    $(e).removeClass("is-invalid")
                }else{
                    belumIsi.push(e)
                }
            })
            if(belumIsi.length > 0){
                belumIsi.forEach(function(e) {
                    $(e).addClass("is-invalid")
                })
            }else{
                let nilai = {}
                data.each(function(i,e) {
                    let id_alternative = $(e).data("id_alternative")
                    let id_criteria = $(e).data("id_criteria")
                    let value = $(e).val()
                    
                    if (!(id_alternative in nilai)) {
                        nilai[id_alternative] = []
                    }

                    nilai[id_alternative].push({
                        id_criteria: id_criteria,
                        value: value
                    })
                })
                console.log(nilai);
                
            }
        });
    });
</script>
</html>