<?php
		class b2cControl extends skymvc{
			
			public function __construct(){
				parent::__construct();
			}
			public function onMenu(){
				$this->smarty->display("menu.html");
			}
			public function onDefault(){
				$this->smarty->display("index.html");
			}
		}
		
		?>