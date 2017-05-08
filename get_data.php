<?php
$mongo      = new MongoClient();
$database   = $mongo->selectDb('dbtest');
$collection = $database->selectCollection('empDetails');

$skip       = (int)$_REQUEST['iDisplayStart'];
$limit      = (int)$_REQUEST['iDisplayLength'];
$search     = $_REQUEST['sSearch'];
$sortIndex  = $_REQUEST['iSortCol_0'];

$sortArray  = array('emp_id', 'first_name', 'last_name', 'position', 'email', 'office', 'start_date', 'age', 'salary', 'projects'
);

$sortByCol  = $sortArray[$sortIndex];
$sortTypeTxt= $_REQUEST['sSortDir_0'];  // asc/desc

$sortType = -1;
if( $sortTypeTxt == 'asc' )
{
    $sortType = 1;
}

if( $search != '' )
{
    $condtion = array(
                    '$or' => array(
                        array('emp_id'    => $search),
                        array('first_name'=> new MongoRegex('/'. $search .'/i')),   // i for case insensitive
                        array('last_name' => new MongoRegex('/'. $search .'/i')),
                        array('position'  => new MongoRegex('/'. $search .'/i')),
                        array('email'     => new MongoRegex('/'. $search .'/i')),
                        array('office'    => new MongoRegex('/'. $search .'/i')),
                        array('start_date'=> new MongoRegex('/'. $search .'/i')),
                        array('age'       => new MongoRegex('/'. $search .'/i')),
                        array('salary'    => new MongoRegex('/'. $search .'/i')),
                        array('projects'  => new MongoRegex('/'. $search .'/i'))
                    )
                );

    $resultSet =   $collection->find($condtion)->limit($limit)->skip($skip)->sort(array($sortByCol => $sortType));
}
else
{
    $resultSet  = $collection->find()->limit($limit)->skip($skip)->sort(array($sortByCol => $sortType))->sort(array($sortByCol => $sortType));
}

$data = array();
if( count( $resultSet ) > 0 )
{
    foreach ($resultSet as $document)
    {
        $data[] = $document;
    }
}

$resultSet  = $collection->find();
$iTotal     = count($resultSet);

$rec = array(
    'iTotalRecords' => $iTotal,
    'iTotalDisplayRecords' => $iTotal,
    'aaData' => array()
);

$k=0;
if (isset($data) && is_array($data)) {

    foreach ($data as $item) {
        $rec['aaData'][$k] = array(
            0  => $item['emp_id'],
            1  => $item['first_name'],
            2  => $item['last_name'],
            3  => $item['position'],
            4  => $item['email'],
            5  => $item['office'],
            6  => $item['start_date'],
            7  => $item['age'],
            8  => $item['salary'],
            9  => $item['projects'],
            10 => '<a href="javascript:void(0);" class="edit_emp" id="'. $item['emp_id'] .'">Edit</a> | <a href="javascript:void(0);" class="delete_emp" id="'. $item['emp_id'] .'">Delete</a>'
        );
        $k++;
    }
}

echo json_encode($rec);

exit;

?>