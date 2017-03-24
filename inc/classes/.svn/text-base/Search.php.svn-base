<?php

set_include_path(implode(PATH_SEPARATOR, array(
    __DIR__,
    get_include_path()
)));

require_once (__DIR__ . "/GeocoderClass.php");
require_once (__DIR__ . "/Property.php");
require_once (__DIR__ . "/DatabaseItem.php");
require_once (__DIR__ . "/SavedSearch.php");

class Search extends DatabaseItem {
    public $lat, $lng, $rentMin, $rentMax, $bedrooms, $bathrooms, $availabilityRequired, $sortBy;
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
        $this -> bedrooms = $post['bedroomnum'];
        $this -> bathrooms = $post['bathroomnum'];
        $this -> availabilityRequired = ($post['onlyavailable'] == "on" ? 1 : 0);
        if (!isset($post['sortby'])) {
            $this -> sortBy = "dist_asc";
        } else {
            $this -> sortBy = $post['sortby'];
        }
    }

    function performSearch($page = 0) {
        $resultsPerPage = 10;

        $offset = $page * $resultsPerPage;
        try {
            $STH = self::$DBH -> prepare("CALL propertySearch(:lat, :lng, :maxDistance, :rentMin, :rentMax, :beds, :baths, :available, :resultsPerPage, :offset, :sortBy)");
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
            $STH -> bindValue(":beds", $this -> bedrooms);
            $STH -> bindValue(":baths", $this -> bathrooms);
            $STH -> bindValue(":available", $this -> availabilityRequired);
            $STH -> bindValue(":resultsPerPage", $resultsPerPage);
            $STH -> bindValue(":offset", $offset);

            $STH -> bindValue(":sortBy", $this -> sortBy);
            $STH -> execute();
            $properties = $STH -> fetchAll();
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }
        // NOTE: in the stored procedure, 1 is added to resultsPerPage. If there needs to be a next page, then the number of properties returned will be 1 larger than the resultsPerPage is set.
        $showNextPage = false;
        if (count($properties) > $resultsPerPage) {
            $showNextPage = true;
            // Sets it to display next page
            array_pop($properties);
            // removes extra result from property list
        }

        $response = array("showNextPage" => $showNextPage, "properties" => $properties);

        return $response;
    }

    function getTotalResultsForSearch() {
        $resultsPerPage = 1000;

        $offset = $page * $resultsPerPage;
        try {
            $STH = self::$DBH -> prepare("CALL propertySearch(:lat, :lng, :maxDistance, :rentMin, :rentMax, :beds, :baths, :available, :resultsPerPage, :offset, :sortBy)");
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
            $STH -> bindValue(":beds", $this -> bedrooms);
            $STH -> bindValue(":baths", $this -> bathrooms);
            $STH -> bindValue(":available", $this -> availabilityRequired);
            $STH -> bindValue(":resultsPerPage", $resultsPerPage);
            $STH -> bindValue(":offset", 0);

            $STH -> bindValue(":sortBy", $this -> sortBy);
            $STH -> execute();
            $properties = $STH -> fetchAll();
        } catch (PDOException $e) {
            echo $e -> getMessage();
        }
        // NOTE: in the stored procedure, 1 is added to resultsPerPage. If there needs to be a next page, then the number of properties returned will be 1 larger than the resultsPerPage is set.
        return count($properties);
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

    function save($searchName) {
        $data = array('User_id' => Authentication::getUserID(), 'searchName' => $searchName, 'Latitude' => $this -> lat, 'Longitude' => $this -> lng, 'RentMin' => $this -> rentMin, 'RentMax' => $this -> rentMax, 'Bedrooms' => $this -> bedrooms, 'Bathrooms' => $this -> bathrooms, 'AvailabilityRequired' => $this -> availabilityRequired);

        if ($data['RentMin'] == self::DEFAULT_RENTMIN) {
            $data['RentMin'] = 0;
        }

        if ($data['RentMax'] == self::DEFAULT_RENTMAX) {
            $data['RentMax'] = 1000000;
        }
        $savedSearch = new SavedSearch();
        $savedSearch -> insert($data);
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