   <?php 
 include'navbar.php';
   if(!isset($_SESSION['name'])){
       header('Location: login.php');
  } ?>

  <!DOCTYPE html>
  <html>
  <head>
      <title>HOME</title>
      <link rel="stylesheet" type="text/css" href="css/style3.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <?php 


      include'connect.php' ?>
 </head>
 <body>

     <div class="container" >
          <table class="table table-dark" style="width: 1300px;position: relative; right: 80px; top: 50px;" >
               <thead>
                    <tr>
                         <th scope="col">學號</th>
                         <th scope="col">姓名:</th>
                         <th scope="col">班級</th>
                         <th scope="col">手機號碼</th>
                         <th scope="col">可工讀時間</th>
                         <th scope="col">申請資格</th>
                         <th scope="col">申請單位</th>
                         <th scope="col">細節/編輯</th>
                         <th scope="col">刪除</th>

                    </tr>
               </thead>
               <?php
               $sql="with tmp as(SELECT DISTINCT sid,
               STUFF((
               SELECT ',' + a.able_time
               FROM able_time a
               WHERE a.sid=b.sid
               FOR XML PATH('')
               ), 1, 1, '') AS able_time
               FROM able_time b),
               tmp2 as(SELECT DISTINCT sid,
               STUFF((
               SELECT ',' + a.work_department
               FROM work_department a
               WHERE a.sid=b.sid
               FOR XML PATH('')
               ), 1, 1, '') AS work_department
               FROM work_department b
               )

               select student_data.sid,name,class,birthday,phone,email,id,telephone,quality,able_time,work_department
               from student_data,tmp,tmp2 where student_data.sid=tmp.sid and student_data.sid=tmp2.sid
               ";
               $qury=sqlsrv_query($conn,$sql) or die("sql error".sqlsrv_errors());

               ?>
               <tbody>
                    <tr>
                         <?php while ($row=sqlsrv_fetch_array($qury)) { ?> <!--return a row as an array -->
                         <tr>

                              <td><?php echo $row['sid'];?></td>
                              <td><?php echo $row['name'];?> </td>
                              <td><?php echo $row['class'];?> </td>
                              <td><?php echo $row['phone'];?></td>
                              <td><?php echo $row['able_time'];?></td> 
                              <td><?php echo $row['quality'];?></td>
                              <td><?php echo $row['work_department'];?></td>
                              <td>
                                   <a href="edit.php?sid=<?php echo $row["sid"];?>" class="btn btn-info">編輯</a>
                              </td>
                              <td>
                                   <a href="delete.php?sid=<?php echo $row["sid"];?>" class="btn btn-danger">刪除</a>
                              </td>
                         </tr>
                    <?php } ?>
               </tr>
          </tbody>
     </table>
</div>

</body>
</html>

