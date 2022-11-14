<html>

<head>
    <title>Mari Belajar Coding</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>


<head>
    <style type="text/css">
        h1 {
            clear: both;
        }

        ul {
            width: 760px;
        }

        #double li {
            width: 50%;
            float: left;
        }

        #triple li {
            width: 33.33%;
            float: bottom;
        }

        ul.menu li a {
            display: block;
            background-color: blue;
            color: white;
            text-decoration: none;
            margin: 1px;
        }

        ul.menu li a:hover {
            background-color: red;
        }

        table {
            border-collapse: collapse;
            width: 500px;
            height: 120px;
        }

        tr,
        td {
            border: 1px solid;
        }
    </style>
</head>

<body>

    <div>
        <label>Test</label>
    </div>

    <?php


foreach ($nomerinduk as $no){
    $sem = $no->nik;
}
foreach ($nama as $n){
    $nam = $n->nama;
}

$arr    = range(1, $sem);
function array_chunk_vertical($arr, $percolnum){
    $n = count($arr);
    $mod    = $n % $percolnum;
    $cols   = floor($n / $percolnum);
    $mod ? $cols++ : null ;
    $re     = array();
    for($col = 0; $col < $cols; $col++){
        for($row = 0; $row < $percolnum; $row++){
            if($arr){
                $re[$row][]   = array_shift($arr);
            }
        }
    }
    return $re;
}

foreach ($nama as $n){
    $nam = $n->nama;
$result = array_chunk($arr, 3);
print "<table>\n";
foreach($result  as $row){
    print "<tr>\n";
    foreach($row as $val){
        print "<td>" . $val .$nam. "</td>\n";
    }
    print "</tr>\n";
}
    }
print "</table>\n";

?>
</body>

</html>