<?php

namespace GrapheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GrapheBundle\Entity\Classe;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

class GrapheController extends Controller
{ public function chartLineAction()

{ $em = $this->container->get('doctrine')->getEntityManager();
    $classes = $em->getRepository('EcommerceBundle:Produit')->findAll();
    $tab = array(); $categories = array();
    foreach ($classes as $classe)
    { array_push($tab, $classe->getVente());
        array_push($categories, $classe->getNom()); }
    $series = array( array("name" => "Total vente", "data" => $tab) );
    $ob = new Highchart();
    $ob->chart->renderTo('linechart');
    $ob->title->text('Total vente par produit');
    $ob->xAxis->title(array('text' => "Nom produit"));
    $ob->yAxis->title(array('text' => "total vente"));
    $ob->xAxis->categories($categories);
    $ob->series($series);
    return $this->render('@Graphe/Graphe/LineChart.html.twig', array( 'chart' => $ob )); }


    public function chartHistogrammeAction()
    { $em= $this->container->get('doctrine')->getEntityManager();
    $classes = $em->getRepository('EcommerceBundle:Produit')->findAll();
    $categories= array(); $nbVentes=array();
    foreach($classes as $classe)
    { array_push($categories,$classe->getNom());
    array_push($nbVentes,$classe->getVente()); }
    $series = array( array( 'name' => 'Etudiant', 'type' => 'column', 'color' => '#4572A7', 'yAxis' => 0, 'data' => $nbVentes, ) );
    $yData = array( array( 'labels' => array( 'formatter' => new Expr('function () { return this.value + "" }'),
        'style' => array('color' => '#4572A7') ), 'gridLineWidth' => 0,
        'title' => array( 'text' => 'Total vente', 'style' => array('color' => '#4572A7') ), ), );
    $ob = new Highchart();
    $ob->chart->renderTo('container');
    $ob->chart->type('column');
    $ob->title->text('Total vente par produit');
    $ob->xAxis->categories($categories);
        $ob->yAxis($yData);
        $ob->legend->enabled(false);
        $formatter = new Expr('function () 
{ var unit = { "Etudiant": "étudiant(s)", }[this.series.name];
 return this.x + ": <b>" + this.y + "</b> " + unit; }');
        $ob->tooltip->formatter($formatter); $ob->series($series);
        return $this->render('@Graphe/Graphe/histogramme.html.twig', array( 'chart' => $ob )); }


    public function chartPieAction()
    { $ob = new Highchart();
    $ob->chart->renderTo('piechart');
    $ob->title->text('Total vente par produit');
    $ob->plotOptions->pie(array( 'allowPointSelect' => true, 'cursor' => 'pointer', 'dataLabels' => array('enabled' => false),
        'showInLegend' => true ));
    $em= $this->container->get('doctrine')->getEntityManager();
    $classes = $em->getRepository('EcommerceBundle:Produit')->findAll();
    $totalVente=0;
    foreach($classes as $classe) { $totalVente=$totalVente+$classe->getVente(); }
    $data= array();
    foreach($classes as $classe) { $stat=array(); array_push($stat,$classe->getNom(),(($classe->getVente()) *100)/$totalVente);
    array_push($data,$stat);}
        $ob->series(array(array('type' => 'pie','name' => 'Browser share', 'data' => $data)));
    return $this->render('@Graphe/Graphe/pie.html.twig', array( 'chart' => $ob ));}}

