<?php 
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_menbre;charset=utf8','root','');
$adoudou = $bdd->prepare("SELECT * FROM site_users WHERE id = ?");
    $adoudou->execute(array($_SESSION['id']));
    $admin = $adoudou->fetch();
$c = $bdd->query("SELECT * FROM menbre WHERE confirm = 0");
$con = 0;
while($co = $c->fetch()){
  $con+=1;

}
if (isset($_GET['del'])) {
  $delete = (int) $_GET['del'];
  $req = $bdd->prepare("DELETE FROM auto WHERE id = ?");
  $req->execute(array($delete));
  echo "<p class = \"container alert alert-danger\">suppresion du candidat reussie</p>";
}
      if (isset($_POST['v'])) {
        if (isset($_POST['first'],$_POST['last'],$_POST['date_de_naissance'],$_POST['session'],$_POST['sexe'],$_POST['age'],$_POST['naissance']) AND !empty($_POST['first']) AND !empty($_POST['last'])  AND !empty($_POST['session'])  AND !empty($_POST['sexe']) AND !empty($_POST['age']) AND !empty($_POST['naissance'])AND !empty($_POST['date_de_naissance'])) {
          $name = htmlspecialchars($_POST['first']);
          $name2 = htmlspecialchars($_POST['last']);        
          $age = htmlspecialchars($_POST['age']);
          $lieu = htmlspecialchars($_POST['naissance']);
          $session = htmlspecialchars($_POST['session']);
          $sexe = htmlspecialchars($_POST['sexe']);
          $naiss = htmlspecialchars($_POST['date_de_naissance']);
          $lenght_name = strlen($_POST['first']);
          $lenght_name2 = strlen($_POST['last']);
          if (preg_match("/^[a-zA-Z ]*$/",$name) AND preg_match("/^[a-zA-Z ]*$/",$name2)){
            if(($age>=18) AND ($age<35)){
                    $insertmbr = $bdd->prepare("INSERT INTO auto(first,last,age,naissance,lieu,sexe,session,date_enreg) VALUES(?,?,?,?,?,?,?,NOW())");
                    $insertmbr->execute(array($name,$name2,$age,$naiss,$lieu,$sexe,$session)); 
                    
                    echo "<script>alert('inscription reussie');</script>";
                  }
                  else{
                    $erreur = "vous n'etes pas admissibles dans notre centre";
                  } 
            }
          else{
            $erreur = "veuillez entrez un identifiant valide";
          }
        }
        else{
          $erreur = "Tous les champs doivent etre rempli";
        }
      }

$sel = $bdd->query("SELECT * FROM auto");
 ?>     
<?php include_once('head.php'); ?>
<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->
         <?php include_once('aside.php'); ?>
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-files-o"></i> auto ecole</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="icon_document_alt"></i>Forms</li>
              <li><i class="fa fa-car"></i>auto ecole</li>
            </ol>
          </div>
        </div>
        <!-- Form validations -->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                <i class="fa fa-car"></i> auto
              </header>
              <div class="panel-body"><br><br>
    <?php if(isset($erreur)) { ?>
      <input class="alert-danger form-control" value = "<?= $erreur?>">
    <?php } ?>
    <form method="post" action="">
      <p align="center">--NOM--<input required="required"  type="text" name="first" placeholder="identifiant" class="form-control"></input></p>
      <p align="center">--PRENOM--<input required="required" type="text" name="last" placeholder="identifiant" class="form-control"></input></p>
      <p align="center">--DATE DE NAISSANCE-- <input type="date" class="form-control" name="date_de_naissance"></input></p>

      <p align="center">--SEXE-- <select required="required" class="form-control" name="sexe">
        <option></option>
        <option>M</option>
        <option>F</option>
      </select></p>
      <p align="center">--SESSION-- <select  required="required" class="form-control" name="session">
    <option></option>    
    <option>JANVIER</option>
    <option>FEVRIER</option>
    <option>MARS</option>
    <option>AVRIL</option>
    <option>MAI</option>
    <option>JUIN</option>
    <option>JUILLET</option>    
    <option>AOUT</option>
    <option>SEPTEMBRE</option>
    <option>OCTOBRE</option>
    <option>NOVEMBRE</span></option>
    <option>DECEMBRE</span></option>
  </select>
      <p align="center">--AGE--<input required="required" type="number" name="age" placeholder="identifiant" class="form-control"></input></p>
      <p align="center">--LIEU DE NAISSANCE--<input required="required" type="text" name="naissance" placeholder="lieu de naissance" class="form-control"></input></p>
      <button type="submit" class="btn-sm btn-info form-control" name="v" onclick="return(confirm('voulez-vous vraiment ajouter ce candidat?'))">inscrire</button>
    </form>
</div>
            </section>
            <?php if (isset($sel)){ ?>
         <div class="row">
          <div class="col-lg-12">
                                   <section class="panel">
              <header class="panel-heading">
                Liste des candidats
              </header>
              <div class="col-lg-12 table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nom && prenom</th>
                      <th>date de naissance</th>
                      <th>sexe</th>
                      <th>session</th>
                      <th>age</th>
                      <th>lieu de naissance</th>
                      <th>date d'enregistrement</th>
                      <th>action</th>
                      
                    </tr>
                  </thead>
              <?php while($bul = $sel->fetch()){ ?>
                  <tbody>
                    <tr>
                      <td><?= $bul['id']?></td>
                      <td><?= $bul['first']." ".$bul['last']?></td>
                      <td><?= $bul['naissance']?></td>
                      <td><?= $bul['sexe']?></td>
                      <td><?= $bul['session']?></td>
                      <td><?= $bul['age']?></td>
                      <td><?= $bul['lieu']?></td>
                      <td><?= $bul['date_enreg']?></td>
                      <td><a onclick="return(confirm('voulez-vous vraiment supprimer ce candidat?'))" href="auto.php?del=<?=$bul['id']?>"> <i class=" btn-sm btn-danger fa fa-times-circle"></i></a></td>
                    </tr>
                  </tbody>
            <?php } ?>
                </table>
              </div>
            </section>
          </div>
        </div>
          </div>
        </div>
      </div>
    </div>
    <?php  }?>
          </div>
        </div>
  </section>
  <!-- container section end -->

  <!-- javascripts -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- jquery validate js -->
  <script type="text/javascript" src="js/jquery.validate.min.js"></script>

  <!-- custom form validation script for this page-->
  <script src="js/form-validation-script.js"></script>
  <!--custome script for all page-->
  <script src="js/scripts.js"></script>


</body>

</html>
