<?php 

$id = $_GET["id"];

session_start();

include("funcs.php");
sschk();

$pdo = db_conn();

// Event title
$sql = "SELECT * from inst WHERE inst_id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false) {
    sql_error($stmt);
}else{
    $r_inst = $stmt->fetch();
}

// students' countries
$sql = "SELECT stu_cntry.stucntry, COUNT(stucntry) as total
FROM stu_cntry
JOIN stuser ON stu_cntry.stucntry_id = stuser.s_stucntry_id
JOIN rsv ON stuser.stuser_id = rsv.r_stuser_id 
JOIN i_event ON rsv.r_e_id = i_event.e_id
JOIN inst ON i_event.e_inst_id = inst.inst_id
WHERE inst.inst_id = :id AND rsv.rsv_flg=1
GROUP BY stu_cntry.stucntry
ORDER BY stu_cntry.stucntry";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
  // $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //* PasswordがHash化する場合はコメントする
$status = $stmt->execute();

$view = "";
$json=[];
$json2=[];
if($status==false) {
    sql_error($stmt);
}else{
//   Selectデータの数だけ自動でループしてくれる
//   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   .=は、+=と同じ。


    while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        extract($r);
        $json[] = $r["stucntry"];
        $json2[]=(int)$r["total"];

        if($stmt->rowCount() > 0){
            $view .= '<tr>';
            $view .= '<td>'.$r["stucntry"].'</td>';
            $view .= '<td>'.$r["total"].'</td>';
            $view .= '</tr>';
        }else{
            $view .= '<tr>';
            $view .= '<td>none</td>';
            $view .= '<td>none</td>';
            $view .= '</tr>';
        }
    }
    // echo json_encode($json);
    // echo json_encode($json2);
}

// Desired detination countries
$sql = "SELECT icntry.icntry, COUNT(icntry) as total
FROM icntry
JOIN stuser_icntry_map ON icntry.icntry_id = stuser_icntry_map.si_icntry_id
JOIN stuser ON stuser_icntry_map.si_stuser_id = stuser.stuser_id
JOIN rsv ON stuser.stuser_id = rsv.r_stuser_id
JOIN i_event ON rsv.r_e_id = i_event.e_id
JOIN inst ON i_event.e_inst_id = inst.inst_id
WHERE inst.inst_id = :id AND rsv.rsv_flg=1
GROUP BY icntry.icntry";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

$view_ic = "";
$json3 = [];
$json4 = [];
if($status==false) {
    sql_error($stmt);
}else{
//   Selectデータの数だけ自動でループしてくれる
//   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   .=は、+=と同じ。
    while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        extract($r);
        $json3[] = $r["icntry"];
        $json4[] = $r["total"];

        if($stmt->rowCount() > 0){
            $view_ic .= '<tr>';
            $view_ic .= '<td>'.$r["icntry"].'</td>';
            $view_ic .= '<td>'.$r["total"].'</td>';
            $view_ic .= '</tr>';
        }else{
            $view_ic .= '<tr>';
            $view_ic .= '<td>0</td>';
            $view_ic .= '<td>0</td>';
            $view_ic .= '</tr>';
        }
      }
    //   echo json_encode($json3);
    //   echo json_encode($json4);
}

// Study level
$sql = "SELECT lvl.lvl, COUNT(lvl) as total
FROM lvl
JOIN stuser_lvl_map ON lvl.lvl_id = stuser_lvl_map.sl_lvl_id
JOIN stuser ON stuser_lvl_map.sl_stuser_id = stuser.stuser_id
JOIN rsv ON stuser.stuser_id = rsv.r_stuser_id
JOIN i_event ON rsv.r_e_id = i_event.e_id
JOIN inst ON i_event.e_inst_id = inst.inst_id
WHERE inst.inst_id = :id AND rsv.rsv_flg=1
GROUP BY lvl.lvl";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

$view_l = "";
$json5 = [];
$json6 = [];
if($status==false) {
    sql_error($stmt);
}else{
//   Selectデータの数だけ自動でループしてくれる
//   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   .=は、+=と同じ。
    while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        extract($r);
        $json5[] = $r["lvl"];
        $json6[] = $r["total"];

        if($stmt->rowCount() > 0){
            $view_l .= '<tr>';
            $view_l .= '<td>'.$r["lvl"].'</td>';
            $view_l .= '<td>'.$r["total"].'</td>';
            $view_l .= '</tr>';
        }else{
            $view_l .= '<tr>';
            $view_l .= '<td>0</td>';
            $view_l .= '<td>0</td>';
            $view_l .= '</tr>';
        }
    }
    // echo json_encode($json5);
    // echo json_encode($json6);
}

// Subject areas
$sql = "SELECT sbj.sbj, COUNT(sbj) as total
FROM sbj
JOIN sbj_stuser_map ON sbj.sbj_id = sbj_stuser_map.ss_sbj_id
JOIN stuser ON sbj_stuser_map.ss_stuser_id = stuser.stuser_id
JOIN rsv ON stuser.stuser_id = rsv.r_stuser_id
JOIN i_event ON rsv.r_e_id = i_event.e_id
JOIN inst ON i_event.e_inst_id = inst.inst_id
WHERE inst.inst_id = :id AND rsv.rsv_flg=1
GROUP BY sbj.sbj";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

$view_s = "";
$json7 = [];
$json8 = [];
if($status==false) {
    sql_error($stmt);
}else{
//   Selectデータの数だけ自動でループしてくれる
//   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   .=は、+=と同じ。
    while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        extract($r);
        $json7[] = $r["sbj"];
        $json8[] = $r["total"];

    if($stmt->rowCount() > 0){
        $view_s .= '<tr>';
        $view_s .= '<td>'.$r["sbj"].'</td>';
        $view_s .= '<td>'.$r["total"].'</td>';
        $view_s .= '</tr>';
    }else{
        $view_s .= '<tr>';
        $view_s .= '<td>0</td>';
        $view_s .= '<td>0</td>';
        $view_s .= '</tr>';
    }
}   
// echo json_encode($json7);
// echo json_encode($json8);
}


// // competitor analysis
// $sql = "SELECT inst.inst_name, COUNT(DISTINCT inst_name) as total
// FROM inst
// JOIN i_event ON inst.inst_id = i_event.e_inst_id 
// JOIN rsv ON i_event.e_id = rsv.r_e_id
// JOIN 
// (SELECT stuser.stuser_id FROM stuser
// JOIN rsv ON stuser.stuser_id = rsv.r_stuser_id
// JOIN i_event ON rsv.r_e_id = i_event.e_id 
// WHERE i_event.e_inst_id = :id) AS stuser
// ON rsv.r_stuser_id = stuser.stuser_id
// GROUP BY inst.inst_name";
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
// $status = $stmt->execute();

// $view_c = "";
// if($status==false) {
//     sql_error($stmt);
// }else{
// //   Selectデータの数だけ自動でループしてくれる
// //   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
// //   .=は、+=と同じ。
//     while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        
//         if($stmt->rowCount() > 0){
//             $view_c .= '<tr>';
//             $view_c .= '<td>'.$r["inst_name"].'</td>';
//             $view_c .= '<td>'.$r["total"].'</td>';
//             $view_c .= '</tr>';
//         }else{
//             $view_c .= '<tr>';
//             $view_c .= '<td>none</td>';
//             $view_c .= '<td>none</td>';
//             $view_c .= '</tr>';
//         }
//     }
//     // echo json_encode($json);
//     // echo json_encode($json2);
// }

// competitor analysis
$sql = "SELECT inst.inst_name
FROM inst
JOIN i_event ON inst.inst_id = i_event.e_inst_id 
JOIN rsv ON i_event.e_id = rsv.r_e_id
JOIN 
(SELECT stuser.stuser_id FROM stuser
JOIN rsv ON stuser.stuser_id = rsv.r_stuser_id
JOIN i_event ON rsv.r_e_id = i_event.e_id 
WHERE i_event.e_inst_id = :id) AS stuser
ON rsv.r_stuser_id = stuser.stuser_id
WHERE NOT inst.inst_id = :i_id 
GROUP BY inst.inst_name";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':i_id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

$view_c = "";
if($status==false) {
    sql_error($stmt);
}else{
//   Selectデータの数だけ自動でループしてくれる
//   FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   .=は、+=と同じ。
    while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        
        if($stmt->rowCount() > 0){
            $view_c .= '<tr>';
            $view_c .= '<td>'.$r["inst_name"].'</td>';
            $view_c .= '</tr>';
        }else{
            $view_c .= '<tr>';
            $view_c .= '<td>none</td>';
            $view_c .= '</tr>';
        }
    }
    // echo json_encode($json);
    // echo json_encode($json2);
}




?>
<!DOCTYPE html>
<html lang="en">

<?php include("templates/i_header01.php")?>

<div class="inner">

    <h1 class="heading">Students Statistics</h1>

    <div class="mb60">
    <p class="sub_heading"><?= $r_inst["inst_name"]?></p>
    </div>

    <div class="mb80">
    
        <p id="btn1" class="c_title pointer"><i class="fas fa-chevron-circle-right"></i>Countries of origins</p> 
        <div id="out_box1" class="out_box1">
            <div class="chart_box">
                <div class="table">
                    <table>
                        <tr>
                            <th>Country</th>
                            <th>Number</th>
                        </tr>
                            <?=$view?>
                    </table>
                </div>
                <div class="pie-chart-container chart">
                    <canvas id="myChart1" width="400px" height="400px"></canvas>
                </div>  
            </div>
        </div>


        <p id="btn2" class="c_title pointer"><i class="fas fa-chevron-circle-right"></i>Desired destinations</p> 
        <div id="out_box2" class="out_box2">
            <div class="chart_box">
                <div class="table">
                    <table>
                        <tr>
                            <th>Destination</th>
                            <th>Number</th>
                        </tr>
                            <?=$view_ic?>
                    </table>
                </div>
                <div class="pie-chart-container chart">
                    <canvas id="myChart2" width="400px" height="400px"></canvas>
                </div> 
            </div>
        </div>

        <p id="btn3" class="c_title pointer"><i class="fas fa-chevron-circle-right"></i>Level of study</p> 
        <div id="out_box3" class="out_box3">
            <div class="chart_box">
                <div class="table">
                    <table>
                        <tr>
                            <th>Level</th>
                            <th>Number</th>
                        </tr>
                            <?=$view_l?>
                    </table>
                </div>
                <div class="pie-chart-container chart">
                    <canvas id="myChart3" width="400px" height="400px"></canvas>
                </div> 
            </div>
        </div>

        <p id="btn4" class="c_title pointer"><i class="fas fa-chevron-circle-right"></i>Subject areas</p> 
        <div id="out_box4" class="out_box4">
            <div class="chart_box">
                <div class="table">
                        <table>
                            <tr>
                                <th>Sbject area</th>
                                <th>Number</th>
                            </tr>
                                <?=$view_s?>
                        </table>
                </div>
                <div class="pie-chart-container1 chart">
                    <canvas id="myChart4" width="800px" height="800px"></canvas>
                </div> 
            </div>
        </div>

        <p id="btn5" class="c_title pointer"><i class="fas fa-chevron-circle-right"></i>Competitor analysis</p> 
        <div id="out_box5" class="out_box5">
            <div class="chart_box">
                <div class="exp">
                <p>The list of universities which the students who took part in your events are interested in.</p>
                </div>
                <div class="table">
                        <table>
                            <tr>
                                <th>University</th>
                            </tr>
                                <?=$view_c?>
                        </table>
                    <!-- </div><div class="pie-chart-container1 chart">
                        <canvas id="myChart4" width="800px" height="800px"></canvas>
                    </div>  -->
                </div>
             </div>
         </div>
    </div>
</div>

<?php include("templates/i_footer.php")?>
<?php include("templates/script.php")?>

<?php include("templates/chart.php")?>

<script>
    const btn1 = document.querySelector("#btn1");

    btn1.addEventListener("click", function(){
        const oBox1 = document.querySelector("#out_box1")

        if(oBox1.style.display=="block"){
            oBox1.style.display="none";
        }else{
            oBox1.style.display="block";
        }
    })

    const btn2 = document.querySelector("#btn2");

    btn2.addEventListener("click", function(){
        const oBox2 = document.querySelector("#out_box2")

        if(oBox2.style.display=="block"){
            oBox2.style.display="none";
        }else{
            oBox2.style.display="block";
        }
    })

    const btn3 = document.querySelector("#btn3");

    btn3.addEventListener("click", function(){
        const oBox3 = document.querySelector("#out_box3")

        if(oBox3.style.display=="block"){
            oBox3.style.display="none";
        }else{
            oBox3.style.display="block";
        }
    })

    const btn4 = document.querySelector("#btn4");

    btn4.addEventListener("click", function(){
        const oBox4 = document.querySelector("#out_box4")

        if(oBox4.style.display=="block"){
            oBox4.style.display="none";
        }else{
            oBox4.style.display="block";
        }
    })

    const btn5 = document.querySelector("#btn5");

    btn5.addEventListener("click", function(){
        const oBox5 = document.querySelector("#out_box5")

        if(oBox5.style.display=="block"){
            oBox5.style.display="none";
        }else{
            oBox5.style.display="block";
        }
    })


</script>
    
</body>
</html>