 <?php

require_once "myPDO.include.php";

if(isset($_GET['id']) && !empty($_GET['id'])){

  $libelleSequence = substr($_GET['id'], 0, 2);
	$identifiantMatiere = substr($_GET['id'], 2, strlen($_GET['id']));

	$pdo = myPDO::getInstance() ;
	$stmt = $pdo->prepare(<<<SQL
		SELECT  *
		FROM Sequence_Pedagogique S, Matiere M, Repartition R
		WHERE S.idMatiere = M.idMatiere
		AND M.idMatiere = :id
    AND S.libSequence = :lib
    AND R.idSequence = S.idSequence
SQL
);
$stmt->bindParam(':id',$identifiantMatiere);
$stmt->bindParam(':lib',$libelleSequence);


    $tab = array() ;
    $stmt -> execute();
    $cpt = 0 ; 
    while (($ligne = $stmt->fetch()) !== false) {
    $tab[$cpt] =  $ligne;
    $cpt++ ; 
  }
  echo json_encode($tab);
}