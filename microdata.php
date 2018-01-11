<!DOCTYPE html>
<html>

<head>

    <title>Microdata - Shane Donnelly</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- JQuery -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- Google Maps -->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCYdlXjb6H0AQ_2mhWQwJVIzmJ7NVvLfgo"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Maplace Google Maps JS -->
    <script src="maplace.min.js"></script>

</head>

<body>
  <div id="wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Microdata Use Cases</h1>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              Microdata Found
            </div>

            <div class="panel-body">

              <?php
                // Read XML file
                $xml=simplexml_load_file("example2.xml");

                // i used as a counter variable to loop through XML
                $i = 0;

                // Foreach user in the xml file, add the attributes to an array
                foreach($xml->user as $user) {
                  $name[$i] = (string)$user->name;
                  $occupation[$i] = (string)$user->job_title;
                  $email[$i] = (string)$user->email;
                  $postcode[$i] = (string)$user->postcode;
                  $telephone[$i] = (string)$user->telephone;
                  $birthDate[$i] = (string)$user->birthDate;
                  $age[$i] = date_diff(date_create($birthDate[$i]), date_create('now'))->y;
                  $medicalCode[$i] = (string)$user->code;
                  $codingSystem[$i] = (string)$user->codingSystem;
                  $medicalCondition[$i] = (string)$user->medicalCondition;
                  $associatedAnatomy[$i] = (string)$user->associatedAnatomy;
                  $cause[$i] = (string)$user->cause;
                  $currentTreatment[$i] = (string)$user->currentTreatment;

                  // Get the latitude and longitude of the postcode and add it to the $addresses array variable
                  $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$postcode[$i].'&sensor=false');
                  $output = json_decode($geocode);
                  $lat = $output->results[0]->geometry->location->lat;
                  $lon = $output->results[0]->geometry->location->lng;
                  $addresses = $addresses . '{lat: ' . $lat . ', lon: ' . $lon .', zoom: 12},';

                  echo '<div class="col-lg-3">
                          <div class="panel panel-info">
                            <div class="panel-heading">
                              Person: '.$name[$i].'
                            </div>
                            <div class="panel-body">';

                  echo '<strong><h3>General Details</strong></h3><strong>Name:</strong> '.$name[$i].'</br><strong>Age:</strong> '.$age[$i].'</br><strong>Occupation:</strong> '.$occupation[$i].
                       '</br><strong>Postcode:</strong> '.$postcode[$i].'</br><strong>Telephone:</strong> '.$telephone[$i].'</br><strong>Email:</strong> '.$email[$i].
                       '</br><strong><h3>Medical Details</strong></h3><strong>Medical Condition: </strong>'.$medicalCondition[$i].'</br><strong>Associated Anatomy: </strong>'.
                        $associatedAnatomy[$i].'</br><strong>Cause: </strong>'.$cause[$i].'</br><strong>Current Treatment: </strong>'.$currentTreatment[$i];

                  echo '</div> </div> </div> ';

                  // Increase the counter variable 'i'
                  $i++;
                }

                // Foreach event in the xml file, add the attributes to an array
                foreach($xml->event as $event) {
                  $eventName[$i] = (string)$event->name;
                  $startDate[$i] = (string)$event->startDate;
                  $eventPostalCode[$i] = (string)$event->postalCode;
                  $doorTime[$i] = (string)$event->doorTime;
                  $duration[$i] = (string)$event->duration;
                  $about[$i] = (string)$event->about;
                  $remainingAttendeeCapacity[$i] = (string)$event->remainingAttendeeCapacity;
                  $maximumAttendeeCapacity[$i] = (string)$event->maximumAttendeeCapacity;

                  // Get the latitude and longitude of the postcode and add it to the $eventAddresses array variable
                  $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$eventPostalCode[$i].'&sensor=false');
                  $output = json_decode($geocode);
                  $lat = $output->results[0]->geometry->location->lat;
                  $lon = $output->results[0]->geometry->location->lng;
                  $eventAddresses = $eventAddresses . '{lat: ' . $lat . ', lon: ' . $lon .', zoom: 12},';

                  echo '<div class="col-lg-3">
                          <div class="panel panel-success">
                            <div class="panel-heading">
                              '.$eventName[$i].' Group
                            </div>
                            <div class="panel-body">';

                  echo '<strong><h3>General Details</strong></h3><strong>Event Name:</strong> '.$eventName[$i].'</br><strong>Location:</strong> '.$eventPostalCode[$i].'</br></br><strong>About:</strong> '.$about[$i].
                       '</br><strong>Current Capacity:</strong> '.$remainingAttendeeCapacity[$i].'/'.$maximumAttendeeCapacity[$i].
                       '</br><strong><h3>Time / Date</strong></h3><strong>Date: </strong>'.$startDate[$i].'</br><strong>Time: </strong>'.
                        $doorTime[$i].'</br><strong>Duration: </strong>'.$duration[$i];


                  echo '</div> </div> </div> ';

                  // Increase the counter variable 'i'
                  $i++;
                }
                ?>


                      </div>
                    </div>
                  </div>
                </div>



                <div class="row">
                  <div class="col-lg-12">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        Medical Condition Statistics
                      </div>

                      <div class="panel-body">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#one" data-toggle="tab"><?php echo ucwords($medicalCondition[0]); ?></a>
                          </li>
                          <li><a href="#two" data-toggle="tab"><?php echo ucwords($medicalCondition[5]); ?></a>
                          </li>
                        </ul>

                        <div class="tab-content">
                          <div class="tab-pane fade in active" id="one">
                            </br>
                            <div class="col-lg-4">
                              <div class="panel panel-default">
                                <div class="panel-heading">
                                  General Statistics
                                </div>

                                <div class="panel-body">
                                  <?php
                                    // Read XML file
                                    $xml=simplexml_load_file("example2.xml");

                                    $numberOfPeopleWithCondition = 0;
                                    $combinedAge = 0;
                                    $ageArray = array();
                                    $causeArray = array();
                                    $treatmentArray = array();

                                    // Foreach user in the xml file
                                    foreach($xml->user as $user) {
                                      if((string)$user->medicalCondition == $medicalCondition[0]) {
                                        $numberOfPeopleWithCondition++;
                                        $birthDate = (string)$user->birthDate;
                                        $cause = (string)$user->cause;
                                        $treatment = (string)$user->currentTreatment;
                                        $age = date_diff(date_create($birthDate), date_create('now'))->y;
                                        $combinedAge = $combinedAge + $age;

                                        $associatedAnatomy = (string)$user->associatedAnatomy;
                                        $medicalCode = (string)$user->code;
                                        $codingSystem = (string)$user->codingSystem;

                                        array_push($ageArray, $age);
                                        array_push($causeArray, $cause);
                                        array_push($treatmentArray, $treatment);
                                      }
                                    }

                                    $values = array_count_values($causeArray);
                                    $values1 = array_count_values($treatmentArray);

                                    echo '<strong>Medical Condition: </strong>'.ucwords($medicalCondition[0]);
                                    echo '</br><strong>Associated Anatomy: </strong>'.ucwords($associatedAnatomy);
                                    echo '</br><strong>Medical Code: </strong>'.$medicalCode.' ('.$codingSystem.')';
                                    echo '</br><strong>Average Age: </strong>'.($combinedAge / $numberOfPeopleWithCondition);
                                    echo '</br><strong>Number of People With Condition: </strong>'.sizeof($ageArray);

                                  ?>
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-4">
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                      Causes
                                  </div>

                                  <div class="panel-body">
                                    <?php
                                      foreach($values as $key => $value) {
                                        echo '<strong>'.ucwords($key).':</strong> '.$value.' people</br>';
                                      }
                                    ?>

                                    </div>
                                  </div>
                                </div>


                                <div class="col-lg-4">
                                  <div class="panel panel-default">
                                    <div class="panel-heading">
                                      Treatments
                                    </div>

                                    <div class="panel-body">
                                      <?php
                                        foreach($values1 as $key => $value) {
                                          echo '<strong>'.ucwords($key).':</strong> '.$value.' people</br>';
                                        }
                                      ?>

                                    </div>
                                  </div>
                                </div>
                              </div>




                              <div class="tab-pane fade" id="two">
                                </br>
                                <div class="col-lg-4">
                                  <div class="panel panel-default">
                                    <div class="panel-heading">
                                      General Statistics
                                    </div>
                                    <div class="panel-body">
                                      <?php
                                        // Read XML file
                                        $xml=simplexml_load_file("example2.xml");

                                        $numberOfPeopleWithCondition = 0;
                                        $combinedAge = 0;
                                        $ageArray = array();
                                        $causeArray = array();
                                        $treatmentArray = array();
                                        // Foreach user in the xml file
                                        foreach($xml->user as $user) {
                                          if((string)$user->medicalCondition == $medicalCondition[5]) {
                                            $numberOfPeopleWithCondition++;
                                            $birthDate = (string)$user->birthDate;
                                            $cause = (string)$user->cause;
                                            $treatment = (string)$user->currentTreatment;
                                            $age = date_diff(date_create($birthDate), date_create('now'))->y;
                                            $combinedAge = $combinedAge + $age;

                                            $associatedAnatomy = (string)$user->associatedAnatomy;
                                            $medicalCode = (string)$user->code;
                                            $codingSystem = (string)$user->codingSystem;

                                            array_push($ageArray, $age);
                                            array_push($causeArray, $cause);
                                            array_push($treatmentArray, $treatment);
                                          }
                                        }

                                        $values = array_count_values($causeArray);
                                        $values1 = array_count_values($treatmentArray);

                                        echo '<strong>Medical Condition: </strong>'.ucwords($medicalCondition[5]);
                                        echo '</br><strong>Associated Anatomy: </strong>'.ucwords($associatedAnatomy);
                                        echo '</br><strong>Medical Code: </strong>'.$medicalCode.' ('.$codingSystem.')';
                                        echo '</br><strong>Average Age: </strong>'.($combinedAge / $numberOfPeopleWithCondition);
                                        echo '</br><strong>Number of People With Condition: </strong>'.sizeof($ageArray);

                                      ?>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-lg-4">
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        Causes
                                      </div>
                                      <div class="panel-body">
                                        <?php
                                          foreach($values as $key => $value) {
                                            echo '<strong>'.ucwords($key).':</strong> '.$value.' people</br>';
                                          }
                                        ?>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-lg-4">
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        Treatments
                                      </div>

                                      <div class="panel-body">
                                        <?php
                                          foreach($values1 as $key => $value) {
                                            echo '<strong>'.ucwords($key).':</strong> '.$value;
                                              if ($value == 1){
                                                echo ' person</br>';
                                              }
                                              else {
                                                echo ' person</br>';
                                              }
                                            }
                                          ?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                             </div>


                             <div class="row">
                               <div class="col-lg-12">
                                 <div class="panel panel-primary">
                                  <div class="panel-heading">
                                      Patients With Lung Cancer (Red) & Blindness (Blue)
                                  </div>

                                  <div class="panel-body">
                                    <div id="gmap-circles" style="width:100%;height:700px;"></div>
                                    <div id="controls"></div>
                                  </div>
                              </div>
                          </div>
                        </div>













    <script type="text/javascript">
    $(function(){
      //The latitude and longitude information can be input automatically using the $eventAddresses and $address variables
      //created above when reading in the XML data, however, when geocoding, this requires a google API key which is not free.
      //Therefore, for demonstration purposes, the information is input manually.
  var LocsA = [
    {
        lat: 52.0362033,
        lon: -0.7613956,
        title: 'Lung Cancer Patient 1',
        html: 'Lung Cancer',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerA.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#FF0000',
          strokeColor: '#990000'
        },
        animation: google.maps.Animation.DROP
    },
    {
        lat: 52.0584912,
        lon: -0.8245051,
        title: 'Lung Cancer Patient 2',
        html: 'Lung Cancer',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerB.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#FF0000',
          strokeColor: '#990000'
        },
        animation:google.maps.Animation.DROP
    },
    {
        lat: 52.2394307,
        lon: -0.988222,
        title: 'Lung Cancer Patient 3',
        html: 'Lung Cancer',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerC.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#FF0000',
          strokeColor: '#990000'
        },
      animation:google.maps.Animation.DROP
    },
    {
        lat: 52.2632179,
        lon: -0.7529852,
        title: 'Lung Cancer Patient 4',
        html: 'Lung Cancer',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerD.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#FF0000',
          strokeColor: '#990000'
        },
      animation:google.maps.Animation.DROP
    },
    {
        lat: 52.295268,
        lon: -0.8049623,
        title: 'Lung Cancer Patient 5',
        html: 'Lung Cancer',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerE.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#FF0000',
          strokeColor: '#990000'
        },
      animation:google.maps.Animation.DROP
    },
    {
        lat: 52.4987979,
        lon: -0.7017984,
        title: 'Blindness Patient 1',
        html: 'Blindness',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerA.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#0000FF'
        },
      animation:google.maps.Animation.DROP
    },
    {
        lat: 52.2842794,
        lon: -0.6070244,
        title: 'Blindness Patient 2',
        html: 'Blindness',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerB.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#0000FF'
        },
      animation:google.maps.Animation.DROP
    },
    {
        lat: 52.3664032,
        lon: -0.5532424,
        title: 'Blindness Patient 3',
        html: 'Blindness',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerC.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#0000FF'
        },
      animation:google.maps.Animation.DROP
    },
    {
        lat: 52.6327995,
        lon: -1.1253367,
        title: 'Blindness Patient 4',
        html: 'Blindness',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerD.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#0000FF'
        },
      animation:google.maps.Animation.DROP
    },
    {
        lat: 52.3789301,
        lon: -1.2489299,
        title: 'Blindness Patient 5',
        html: 'Blindness',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerE.png',
        type: 'circle',
        circle_options: {
          radius: 5000,
          fillColor: '#0000FF'
        },
      animation:google.maps.Animation.DROP
    },
    {
        lat: 52.236402,
        lon: -0.894115,
        title: 'Cancer Support Group',
        html: 'Cancer Support Group - 2018-01-05',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerA.png',
        type: 'circle',
        circle_options: {
          radius: 30000,
          fillColor: '#FF0000',
          strokeColor: '#990000',
          fillOpacity: 0.05
        },
        animation:google.maps.Animation.DROP
    },
    {
        lat: 52.043973,
        lon: -0.748772,
        title: 'Blindness Support Group',
        html: 'Blindness Support Group - 2018-01-07',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerB.png',
        type: 'circle',
        circle_options: {
          radius: 30000,
          fillColor: '#0000FF',
          fillOpacity: 0.05
        },
        animation:google.maps.Animation.DROP
    },
    {
        lat: 52.385664,
        lon: -0.708719,
        title: 'Cancer Support Group',
        html: 'Cancer Support Group - 2018-02-01',
        zoom: 10,
        icon: 'https://maps.google.com/mapfiles/markerC.png',
        type: 'circle',
        circle_options: {
          radius: 30000,
          fillColor: '#FF0000',
          strokeColor: '#990000',
          fillOpacity: 0.05
        },
        animation:google.maps.Animation.DROP
    }
];
    new Maplace({
    locations: LocsA,
    map_div: '#gmap-circles',
    view_all_text: 'Points of interest',

    shared: {
        zoom: 10,
        html: '%index'
    }
  }).Load();

});
    </script>

</body>

</html>
