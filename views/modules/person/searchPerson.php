<?php
if($_SESSION["typeUser"]<>'Admin' && $_SESSION["typeUser"]<>'Preceptor/a'){
	header("location:index.php?action=ingresar");
	exit();
}
?>
<div class="alert alert-info" >
 <label for="">Agregar alumno a la base de datos</label>
</div>
<div>
 <a  class="btn btn-primary" href="index.php?action=createPerson">Nuevo Alumno</a>
</div>
<div class="alert alert-info" >
 <label for="">Buscar y modificar datos de Alumno</label>
</div>

<form class="" action="" method="post">
  <div class="col-md-12"><label class="control-label" for="lastnameRegistro">Tipo de Usuario</label></div>
  <div class="col-md-12">
    <?php
    if($_SESSION["typeUser"]=='Preceptor/a'){
      echo '<input type="text" name="typeuser" Value="Alumno" readonly>';
    }else{
      ?>
      <select class="control-form" name="typeuser">
          <option value="Alumno">Alumno</option>
          <option value="Docente">Docente</option>
          <option value="Tutor">Tutor</option>
          <option value="Director/a">Director/a</option>
          <option value="Preceptor/a">Preceptor/a</option>
          <option value="Admin">Administrador</option>
      </select>

    <?php
    }

    ?>

  </div>
  <label for="">Apellido</label>
  <input type="text" name="lastname" value="">
  <label for="">Nombre</label>
  <input type="text" name="firstname" value="">
  <label for="">DNI</label>
  <input type="text" name="dni" value="">
  <input type="submit" name="searchPersonSubmit" value="Buscar">

</form>

<?php
if($_POST){
  $resultado = new ControllerPerson();
  $dato=$resultado->searchPersonController('form');
  //var_dump($dato);
  echo '<table class="table table-condensed">';
  echo '<thead>
              <tr>
                <th>Id</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>CUIL</th>
                <th>Tipo</th>
                <th>Curso</th>
                <th>Tutor1</th>
                <th>Tutor2</th>';
  foreach ($dato as $key => $item) {
    echo '<tr>
      <td>'.$item["person_id"].'</td>
      <td>'.$item["lastname"].'</td>
      <td>'.$item["firstname"].'</td>
      <td>'.$item["dni"].'</td>
      <td>'.$item["cuil"].'</td>
      <td>'.$item["type"].'</td>';
      echo '<td>';
      if($item["type"]=='Alumno'){
        $inscription = new ControllerCourse();
        //var_dump($inscription);
        $verificar = $inscription->searchStudentInCourseController($item["person_id"]);
        if($verificar){
          echo $verificar[0]['name'].' '.$verificar[0]['turn'];
        }else{
          echo "Sin Asignar";
        }


          //var_dump($verificar);


      }
      echo '</td>';
      echo '<td>tutor1</td>
      <td>tutor2</td>
      <td><a href="index.php?action=editarPerson&id='.$item["person_id"].'"><button>Editar</button></a></td>';
      //echo ' <td><a href="index.php?action=person&idBorrar='.$item["person_id"].'"><button>Borrar</button></a></td>';
    echo '</tr>';
  }
  echo '</table>';
}
?>
