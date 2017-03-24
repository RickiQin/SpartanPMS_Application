<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once (__DIR__ . "/GeocoderClass.php");
require_once (__DIR__ . "/Property.php");
require_once (__DIR__ . "/DatabaseItem.php");

class ApplicationSearch extends DatabaseItem {
    public $lat, $lng, $rentMin, $rentMax;
    const DEFAULT_ADDRESS = "Address, City, or Zipcode";
    const DEFAULT_RENTMIN = "min";
    const DEFAULT_RENTMAX = "max";

    function __construct($post = null) {
        parent::__construct();

        if ($post) {
            $this -> setupSearch($post);
        }
    }

    function setupSearch($post) {
        $result = Geocoder::geocode($post['mainsearch']);
        $this -> lat = $result['latitude'];
        $this -> lng = $result['longitude'];
        $this -> rentMin = $post['rentMin'];
        $this -> rentMax = $post['rentMax'];
    }

    function performSearch($page = 0) {
        $resultsPerPage = 10;

        $offset = $page * $resultsPerPage;
        try {
            $STH = self::$DBH -> prepare("CALL applicationSearch(:lat, :lng, :maxDistance, :rentMin, :rentMax, :resultsPerPage, :offset)");
            // DESCRIPTION (lat, lng, distance (miles), rentMin, rentMax, beds, baths, available, limit, offset, return Total rows for pagination)
            $STH -> bindValue(":lat", $this -> lat);
            $STH -> bindValue(":lng", $this -> lng);
            $STH -> bindValue(":maxDistance", 50);
            if ($this -> rentMin != self::DEFAULT_RENTMIN) {
                $STH -> bindValue(":rentMin", $this -> rentMin);
            } else {
                $STH -> bindValue(':rentMin', 0);
            }

            if ($this -> rentMax != self::DEFAULT_RENTMAX) {
                $STH -> bindValue(":rentMax", $this -> rentMax);
            } else {
                $STH -> bindValue(':rentMax', 100000);
            }
            $STH -> bindValue(":resultsPerPage", $resultsPerPage);
            $STH -> bindValue(":offset", $offset);

            $STH -> execute();
            $applications = $STH -> fetchAll();
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }

        return $applications;
    }

    function getTotalResultsForSearch() {
        $resultsPerPage = 1000;

        $offset = $page * $resultsPerPage;
        try {
            $STH = self::$DBH -> prepare("CALL applicationSearch(:lat, :lng, :maxDistance, :rentMin, :rentMax, :resultsPerPage, :offset)");
            // DESCRIPTION (lat, lng, distance (miles), rentMin, rentMax, beds, baths, available, limit, offset, return Total rows for pagination)
            $STH -> bindValue(":lat", $this -> lat);
            $STH -> bindValue(":lng", $this -> lng);
            $STH -> bindValue(":maxDistance", 25);
            if ($this -> rentMin != self::DEFAULT_RENTMIN) {
                $STH -> bindValue(":rentMin", $this -> rentMin);
            } else {
                $STH -> bindValue(':rentMin', 0);
            }

            if ($this -> rentMax != self::DEFAULT_RENTMAX) {
                $STH -> bindValue(":rentMax", $this -> rentMax);
            } else {
                $STH -> bindValue(':rentMax', 100000);
            }
            $STH -> bindValue(":resultsPerPage", $resultsPerPage);
            $STH -> bindValue(":offset", 0);

            $STH -> bindValue(":sortBy", $this -> sortBy);
            $STH -> execute();
            $applications = $STH -> fetchAll();
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }

        return count($applications);
    }

    function getPagination($page = 0) {
        $totalPages = ceil($this -> getTotalResultsForSearch() / 10);    
            
        $html = '<ul id="pagination-clean">';
        if($page > 0) {
            $html .= '<li class="previous"><a href="?page=' . ($page - 1) . '">Previous</li>';
        } else {
            $html .= '<li class="previous-off">Previous</li>';
        }
        
        for($i = 0; $i < $totalPages; $i++) {
            if($i == $page) {
                $html .= '<li class="active">' . ($i + 1) . '</li>';
            } else {
                $html .= '<li><a href="?page=' . $i . '">' . ($i + 1) . '</a></li>';
            }
        }
        
        if(($page + 1) < $totalPages) {
            $html .= '<li class="next"><a href="?page=' . ($page + 1) . '">Next</a></li>';
        } else {
            $html .= '<li class="next-off">Next</li>';
        }
        
        return $html;
    }

    function distanceToString($rawDistance) {
        if ($rawDistance < 0.1) {
            return "Less than 0.1";
        } else {
            return round($rawDistance, 2);
        }
    }

}
?>