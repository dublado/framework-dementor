<?php
/*
 $conn = new CONN("dub");

 $resultados = $conn->query("select * from itens");
 //exit;

 //$resultados = $conn->prepare("select * from itens");$resultados->execute();


 $pages = new Paginator;
 $pages->items_per_page=7;
 $pages->mid_range=7;
 $pages->items_total = $resultados->rowCount();


 $pages->paginate();

 $resultados = $conn->prepare("select * from itens $pages->limit;");$resultados->execute();

 echo $pages->display_pages();
 echo "<br>";
 echo $pages->display_jump_menu();


 ?>
 <h1 id="teste">TESTE</h1><?php
 while($rs = $resultados->fetchObject()){
 echo $rs->titulo."<br>";
 }

 */

class Paginator {

	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $default_ipp = 25;
	var $querystring;

	function __construct(){

		$this->next = "Próximo";
		$this->prev = "Anterior";
		$this->classpag = "classpag";
		$this->classpagin = "classpagin";
		$this->gotopage = "Ir para a página";
		$this->classcurrent = "classcurrent";
		$this->de = "de";
		$this->classinactive = "inativo";
		$this->all = "tudo";
		$this->itenspp = "Itens por página";
		$this->page = "Página";


	}

	function Paginator() {
		$this->current_page = 1;
		$this->mid_range = 7;
		$this->items_per_page = (!empty($ipp)) ? $ipp:$this->default_ipp;
	}
	
	// TODO fix the return of display_pages to show range of numbers
	function paginate() {
		$ipp = isset($_GET['ipp']) ? $_GET['ipp']: $this->default_ipp;
		$page = isset($_GET['page']) ? $_GET['page']: 1;

		if($ipp == 'All') {
			$this->num_pages = ceil($this->items_total/$this->default_ipp);
			$this->items_per_page = $this->default_ipp;
		} else {
			if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
			$this->num_pages = ceil($this->items_total/$this->items_per_page);
		}
		$this->current_page = (int) $page;
		if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;

		if($_GET) {
			$args = explode("&",$_SERVER['QUERY_STRING']);
			foreach($args as $arg) {
				$keyval = explode("=",$arg);
				if($keyval[0] != "page" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
			}
		}

		if($_POST) {
			foreach($_POST as $key=>$val) {
				if($key != "page" And $key != "ipp") $this->querystring .= "&$key=$val";
			}
		}

		if($this->num_pages > 1) {
			$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"$this->classpag\" href=\"$_SERVER[PHP_SELF]?page=$prev_page&ipp=$this->items_per_page$this->querystring\">&laquo; $this->prev</a> ":"<span class=\"$this->classinactive\" href=\"#\">&laquo; $this->prev</span> ";

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0) {
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages) {
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range, $this->end_range);
			$separator = "";
			for($i=1;$i<=$this->num_pages;$i++) {
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= "$separator...";
				// loop through all pages. if first, last, or in range, display
				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range)) {
					$this->return .= ($i == $this->current_page And $page != 'All') ?
						//SELECTED
						"$separator  <a title=\"$this->gotopage $i de $this->num_pages\" class=\"$this->classcurrent\" href=\"#\">$i</a> ":

						"$separator <a class=\"$this->classpag\" title=\"$this->gotopage $i $this->de $this->num_pages\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= "$separator...";

				$separator=" | ";
			}

			$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($page != 'All')) ?
			//ESCREVE O PROXIMO
			"<a class=\"$this->classpag\" href=\"$_SERVER[PHP_SELF]?page=$next_page&ipp=$this->items_per_page$this->querystring\">$this->next &raquo;</a>\n":
			//ESCREVE O PROXIMO FINAL
			"<span class=\"$this->classinactive\" href=\"#\">&raquo; $this->next</span>\n";


			//ESCREVE O TUDO
			//$this->return .= ($page == 'All') ? "<a class=\"$this->classcurrent\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"$this->classpag\" style=\"margin-left:10px\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">$this->all</a> \n";

		}
		else {
			$separator = "";
			for($i=1;$i<=$this->num_pages;$i++) {
				$this->return .= ($i == $this->current_page) ? "$separator<a class=\"$this->classcurrent\" href=\"#\">$i</a> ":"$separator<a class=\"$this->classpag\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
				$separator="| ";
			}
			//$this->return .= "<a class=\"$this->classpag\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">$this->all</a> \n";
		}
		$this->low = ($this->current_page-1) * $this->items_per_page;
		$this->high = ($ipp == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
		$this->limit = ($ipp == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
	}
	
	function paginateDiff() {
		$ipp = isset($_GET['ipp']) ? $_GET['ipp']: $this->default_ipp;
		$page = isset($_GET['page']) ? $_GET['page']: 1;

		if($ipp == 'All') {
			$this->num_pages = ceil($this->items_total / $this->default_ipp);
			$this->items_per_page = $this->default_ipp;
		} else {
			if(!is_numeric($this->items_per_page) || $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
			$this->num_pages = ceil($this->items_total / $this->items_per_page);
		}
		$this->current_page = (int) $page;
		if($this->current_page < 1 || !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page - 1;
		$next_page = $this->current_page + 1;

		if($_GET) {
			$args = explode("&",$_SERVER['QUERY_STRING']);
			foreach($args as $arg) {
				$keyval = explode("=",$arg);
				if($keyval[0] != "page" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
			}
		}

		if($_POST) {
			foreach($_POST as $key => $val) {
				if($key != "page" And $key != "ipp") $this->querystring .= "&$key=$val";
			}
		}

		if($this->num_pages > 10) {
			$this->return = ($this->current_page != 1 And $this->items_total >= 10) ? 
									"<a class=\"$this->classpag\" href=\"$_SERVER[PHP_SELF] ?  
										page=$prev_page&ipp=$this->items_per_page$this->querystring\"><img src='images/prev.jpg' class='prev_img_pag' border='0' /></a> " : "<span class=\"$this->classinactive\" href=\"#\"><img src='images/prev.jpg' class='prev_img_pag' border='0' /></span> ";

			$this->start_range = $this->current_page - floor($this->mid_range/2);
			$this->end_range = $this->current_page + floor($this->mid_range/2);

			if($this->start_range <= 0) {
				$this->end_range += abs($this->start_range)+1;
				$this->start_range = 1;
			}
			if($this->end_range > $this->num_pages) {
				$this->start_range -= $this->end_range-$this->num_pages;
				$this->end_range = $this->num_pages;
			}
			$this->range = range($this->start_range,$this->end_range);

			for($i = 1; $i <= $this->num_pages; $i++) {
				if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
				// loop through all pages. if first, last, or in range, display
				if($i == 1 Or $i == $this->num_pages Or in_array($i, $this->range)) {
					$this->return .= ($i == $this->current_page And $page != 'All') ? 
						"<a title=\"$this->gotopage $i de $this->num_pages\" class=\"$this->classcurrent\" href=\"#\">$i</a> " :
						"<a class=\"$this->classpag\" title=\"$this->gotopage $i $this->de $this->num_pages\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";
			}
			$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($page != 'All')) ? "<a class=\"$this->classpag\" href=\"$_SERVER[PHP_SELF]?page=$next_page&ipp=$this->items_per_page$this->querystring\"><img src='images/next.jpg' class='next_img_pag' border='0' /></a>\n":"<span class=\"$this->classinactive\" href=\"#\"><img src='images/next.jpg' class='next_img_pag' border='0' /></span>\n";
			//$this->return .= ($page == 'All') ? "<a class=\"$this->classcurrent\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"$this->classpag\" style=\"margin-left:10px\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">$this->all</a> \n";
		} else {
			for($i = 1; $i <= $this->num_pages; $i++) { 
				$this->return .= ($i == $this->current_page) ? "<a class=\"$this->classcurrent\" href=\"#\">$i</a> " : 
															   "<a class=\"$this->classpag\" href=\"$_SERVER[PHP_SELF]?page=$i&ipp=$this->items_per_page$this->querystring\">$i</a> ";
			}
			//$this->return .= "<a class=\"$this->classpag\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">$this->all</a> \n";
		}
		$this->low = ($this->current_page - 1) * $this->items_per_page;
		$this->high = ($ipp == 'All') ? $this->items_total:($this->current_page * $this->items_per_page) - 1;
		$this->limit = ($ipp == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
	} 

	function display_items_per_page() {
		$items = ''; 
		$ipp_array = array(10,25,50,100,'All');
		foreach($ipp_array as $ipp_opt)	$items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
		return "<span class=\"$this->classpag\">$this->itenspp:</span><select class=\"$this->classpag\" onchange=\"window.location='$_SERVER[PHP_SELF]?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
	}

	function display_jump_menu() {
		$option="";

		for($i=1;$i<=$this->num_pages;$i++) {
			$option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
		}
		return "<span class=\"$this->classpag\">$this->page:</span><select class=\"$this->classpag\" onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
	}

	function display_pages() {
		return $this->return;
	}
}
