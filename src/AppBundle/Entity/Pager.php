<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of Pager
 *
 * @author james
 */
class Pager {
    //put your code here
    
        public $TotalItems;
        public $Page;
        public $PageSize;
        public $TotalPages;
        public $StartPage;
        public $EndPage;
    
        public function __construct($totalItems, $page, $pageSize = 1) {
            
            $totalPages = ceil($totalItems/$pageSize);
            $currentPage = $page != null ? $page : 1;
            $startPage = $currentPage - 5;
            $endPage = $currentPage + 4;
            if ($startPage <= 0) {
                // add negative onto end page
                // including 0 ?
                $endPage -= ($startPage - 1);
                $startPage = 1;
            }
            
            if ($endPage > $totalPages)
            {
                
                // keeps adding four to the current page, so change to total pages near end(if end is greater than total)
                $endPage = $totalPages;
               
                // if endPage/totalPages is > 10                
                if ($endPage > 10)
                {
                    // if end page is greater than 10 then make start page relative to end page
                        // start page does not = $currentPage - 5 
                        // for e.g. if 11 was current page,
                        // start page would be 6, 6 page links would be displayed
                        // when there are more links that can be displayed, 10 is default
                    
                    $startPage = $endPage - 9;
                }
            }

            $this->TotalItems = $totalItems;
            $this->Page = $currentPage;
            $this->PageSize = $pageSize;
            $this->TotalPages = $totalPages;
            $this->StartPage = $startPage;
            $this->EndPage = $endPage;
        }
}
