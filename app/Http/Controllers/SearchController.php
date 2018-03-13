<?php

namespace App\Http\Controllers;

use App\Table1;
use App\Table2;
use App\InvalidLocation;
use App\Table3;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $random_number = rand(1, 50);
        $comercializadores = Table1::find(21);
        $single_map = $comercializadores;
        $final_coordinate = array();
        if (($single_map->COORDENADA_X == null || $single_map->COORDENADA_X == "") && ($single_map->COORDENADA_Y == null || $single_map->COORDENADA_Y == "")) {
            $single_address = $single_map->DIRECCION;
            $single_province = $single_map->ISLA;
            $single_zip = $single_map->CP;
            $results = app('geocoder')->geocode($single_address.','.$single_province)->get();
            $length_result = count($results);
            if ($length_result > 0) {
                $coordinates = $results->first()->getCoordinates();
                $coorlng = $coordinates->getLongitude();
                $coorlat = $coordinates->getLatitude();
                $final_coordinate = array(
                    'id' => $single_map->id,
                    'table' => 1,
                    'direction' => $single_map->DIRECCION,
                    'isla' => $single_map->ISLA,
                    'zip' => $single_map->CP,
                    'fax' => $single_map->FAX,
                    'mobile' => $single_map->MOVIL,
                    'telephone' => $single_map->TELEFONO,
                    'email' => $single_map->EMAIL,
                    'lng' => $coorlng,
                    'lat' => $coorlat,
                    'icon' => asset('images/3.png')
                );
                $single_map->COORDENADA_X = $coorlat;
                $single_map->COORDENADA_Y = $coorlng;
                $single_map->save();
            } else {
                $check_exist = InvalidLocation::where('location_id', $single_map->id)->where('table_name', 'V_ECO_PRODUCTORES')->count();
                if ($check_exist == 0) {
                    $invalid = new InvalidLocation;
                    $invalid->location_id = $single_map->id;
                    $invalid->table_name = "V_ECO_PRODUCTORES";
                    $invalid->save();
                }
            }
        } else {
            $final_coordinate = array(
                'id' => $single_map->id,
                'table' => 1,
                'direction' => $single_map->DIRECCION,
                'isla' => $single_map->ISLA,
                'zip' => $single_map->CP,
                'fax' => $single_map->FAX,
                'mobile' => $single_map->MOVIL,
                'telephone' => $single_map->TELEFONO,
                'email' => $single_map->EMAIL,
                'lng' => $single_map->COORDENADA_Y,
                'lat' => $single_map->COORDENADA_X,
                'icon' => asset('images/1.png')
            );
        }
        $total_munisipios = $this->getMunicipiosArray();
        $total_islas = $this->getIslassArray();
        $total_province = $this->getProvinceArray();
        $total_productos = $this->getProductosArray();
        return view('main', [
            'coordinator' => $final_coordinate,
            'total_municipios' => $total_munisipios,
            'total_islas' => $total_islas,
            'total_provincia' => $total_province,
            'total_productos' => $total_productos,
            'real_data' => $comercializadores,
        ]);
    }

    public function search_data(Request $request)
    {
        $address = $request->address;
        $operador = $request->operador;
        $islas = $request->islas;
        $municipios = $request->municipios;
        $provincia = $request->provincia;
        $productos = $request->productos;
        $where_query = array();
        if ($address) {
            array_push($where_query, ['DIRECCION', 'LIKE', '%'.$address.'%']);
        }
        if ($operador) {
            array_push($where_query, ['TIPO_OPERADOR', 'LIKE', '%'.$operador.'%']);
        }
        if ($islas) {
            array_push($where_query, ['ISLA', 'LIKE', '%'.$islas.'%']);
        }
        if ($municipios) {
            array_push($where_query, ['MUNICIPIO', 'LIKE', '%'.$municipios.'%']);
        }
        if ($provincia) {
            array_push($where_query, ['PROVINCIA', 'LIKE', '%'.$provincia.'%']);
        }
        // return $where_query;

        $comercializadores1 = Table1::where($where_query)->get();
        $comercializadores2 = Table2::where($where_query)->get();
        if ($productos) {
            $comercializadores3 = Table3::where($where_query)->where('PRODUCTOS', 'LIKE', '%'.$productos.'%')->get();
        } else {
            $comercializadores3 = Table3::where($where_query)->get();
        }

        if (count($comercializadores1) > 0 || count($comercializadores2) > 0 || count($comercializadores3) > 0) {
            $final_coordinate = array();
            if ($comercializadores1) {
                foreach ($comercializadores1 as $single_map) {
                    if (($single_map->COORDENADA_X == null || $single_map->COORDENADA_X == "") && ($single_map->COORDENADA_Y == null || $single_map->COORDENADA_Y == "")) {
                        $single_address = $single_map->DIRECCION;
                        $single_province = $single_map->PROVINCIA;
                        $single_zip = $single_map->CP;
                        $results = app('geocoder')->geocode($single_address.','.$single_province)->get();
                        $length_result = count($results);
                        if ($length_result > 0) {
                            $coordinates = $results->first()->getCoordinates();
                            $coorlng = $coordinates->getLongitude();
                            $coorlat = $coordinates->getLatitude();
                            $final_coordinate[] = array(
                                'id' => $single_map->id,
                                'table' => 1,
                                'direction' => $single_map->DIRECCION,
                                'isla' => $single_map->ISLA,
                                'zip' => $single_map->CP,
                                'fax' => $single_map->FAX,
                                'mobile' => $single_map->MOVIL,
                                'telephone' => $single_map->TELEFONO,
                                'email' => $single_map->EMAIL,
                                'lng' => $coorlng,
                                'lat' => $coorlat,
                                'icon' => asset('images/1.png')
                            );
                            $single_map->COORDENADA_X = $coorlat;
                            $single_map->COORDENADA_Y = $coorlng;
                            $single_map->save();
                        } else {
                            $check_exist = InvalidLocation::where('location_id', $single_map->id)->where('table_name', 'V_ECO_COMERCIALIZADORES')->count();
                            if ($check_exist == 0) {
                                $invalid = new InvalidLocation;
                                $invalid->location_id = $single_map->id;
                                $invalid->table_name = "V_ECO_COMERCIALIZADORES";
                                $invalid->save();
                            }
                        }
                    } else {
                        $final_coordinate[] = array(
                            'id' => $single_map->id,
                            'table' => 1,
                            'direction' => $single_map->DIRECCION,
                            'isla' => $single_map->ISLA,
                            'zip' => $single_map->CP,
                            'fax' => $single_map->FAX,
                            'mobile' => $single_map->MOVIL,
                            'telephone' => $single_map->TELEFONO,
                            'email' => $single_map->EMAIL,
                            'lng' => $single_map->COORDENADA_Y,
                            'lat' => $single_map->COORDENADA_X,
                            'icon' => asset('images/1.png')
                        );
                    }
                }
            }

            if ($comercializadores2) {
                foreach ($comercializadores2 as $single_map) {
                    if (($single_map->COORDENADA_X == null || $single_map->COORDENADA_X == "") && ($single_map->COORDENADA_Y == null || $single_map->COORDENADA_Y == "")) {
                        $single_address = $single_map->DIRECCION;
                        $single_province = $single_map->PROVINCIA;
                        $single_zip = $single_map->CP;
                        $results = app('geocoder')->geocode($single_address.','.$single_province)->get();
                        $length_result = count($results);
                        if ($length_result > 0) {
                            $coordinates = $results->first()->getCoordinates();
                            $coorlng = $coordinates->getLongitude();
                            $coorlat = $coordinates->getLatitude();
                            $final_coordinate[] = array(
                                'id' => $single_map->id,
                                'table' => 2,
                                'direction' => $single_map->DIRECCION,
                                'isla' => $single_map->ISLA,
                                'zip' => $single_map->CP,
                                'fax' => $single_map->FAX,
                                'mobile' => $single_map->MOVIL,
                                'telephone' => $single_map->TELEFONO,
                                'email' => $single_map->EMAIL,
                                'lng' => $coorlng,
                                'lat' => $coorlat,
                                'icon' => asset('images/2.png')
                            );
                            $single_map->COORDENADA_X = $coorlat;
                            $single_map->COORDENADA_Y = $coorlng;
                            $single_map->save();
                        } else {
                            $check_exist = InvalidLocation::where('location_id', $single_map->id)->where('table_name', 'V_ECO_INDUSTRIAS')->count();
                            if ($check_exist == 0) {
                                $invalid = new InvalidLocation;
                                $invalid->location_id = $single_map->id;
                                $invalid->table_name = "V_ECO_INDUSTRIAS";
                                $invalid->save();
                            }
                        }
                    } else {
                        $final_coordinate[] = array(
                            'id' => $single_map->id,
                            'table' => 2,
                            'direction' => $single_map->DIRECCION,
                            'isla' => $single_map->ISLA,
                            'zip' => $single_map->CP,
                            'fax' => $single_map->FAX,
                            'mobile' => $single_map->MOVIL,
                            'telephone' => $single_map->TELEFONO,
                            'email' => $single_map->EMAIL,
                            'lng' => $single_map->COORDENADA_Y,
                            'lat' => $single_map->COORDENADA_X,
                            'icon' => asset('images/2.png')
                        );
                    }
                }
            }

            if ($comercializadores3) {
                foreach ($comercializadores3 as $single_map) {
                    if (($single_map->COORDENADA_X == null || $single_map->COORDENADA_X == "") && ($single_map->COORDENADA_Y == null || $single_map->COORDENADA_Y == "")) {
                        $single_address = $single_map->DIRECCION;
                        $single_province = $single_map->PROVINCIA;
                        $single_zip = $single_map->CP;
                        $results = app('geocoder')->geocode($single_address.','.$single_province)->get();
                        $length_result = count($results);
                        if ($length_result > 0) {
                            $coordinates = $results->first()->getCoordinates();
                            $coorlng = $coordinates->getLongitude();
                            $coorlat = $coordinates->getLatitude();
                            $final_coordinate[] = array(
                                'id' => $single_map->id,
                                'table' => 3,
                                'direction' => $single_map->DIRECCION,
                                'isla' => $single_map->ISLA,
                                'zip' => $single_map->CP,
                                'fax' => $single_map->FAX,
                                'mobile' => $single_map->MOVIL,
                                'telephone' => $single_map->TELEFONO,
                                'email' => $single_map->EMAIL,
                                'lng' => $coorlng,
                                'lat' => $coorlat,
                                'icon' => asset('images/2.png')
                            );
                            $single_map->COORDENADA_X = $coorlat;
                            $single_map->COORDENADA_Y = $coorlng;
                            $single_map->save();
                        } else {
                            $check_exist = InvalidLocation::where('location_id', $single_map->id)->where('table_name', 'V_ECO_PRODUCTORES')->count();
                            if ($check_exist == 0) {
                                $invalid = new InvalidLocation;
                                $invalid->location_id = $single_map->id;
                                $invalid->table_name = "V_ECO_PRODUCTORES";
                                $invalid->save();
                            }
                        }
                    } else {
                        $final_coordinate[] = array(
                            'id' => $single_map->id,
                            'table' => 3,
                            'direction' => $single_map->DIRECCION,
                            'isla' => $single_map->ISLA,
                            'zip' => $single_map->CP,
                            'fax' => $single_map->FAX,
                            'mobile' => $single_map->MOVIL,
                            'telephone' => $single_map->TELEFONO,
                            'email' => $single_map->EMAIL,
                            'lng' => $single_map->COORDENADA_Y,
                            'lat' => $single_map->COORDENADA_X,
                            'icon' => asset('images/3.png')
                        );
                    }
                }
            }

            $view = view('result_view',compact('comercializadores1', 'comercializadores2', 'comercializadores3'))->render();

            if (count($final_coordinate) > 0) {
                return response()->json(["map_data" => $final_coordinate, 'html' => $view]);
            } else {
                return response()->json(["map_data" => "invalid", 'html' => $view]);
            }
        }
        return "fail";
    }

    public function result_page($id, $table)
    {
        $comercializadores = "";
        if ($table == 1) {
            $comercializadores = Table1::find($id);
            $image = asset('images/1.png');
        } elseif ($table == 2) {
            $comercializadores = Table2::find($id);
            $image = asset('images/2.png');
        } elseif ($table == 3) {
            $comercializadores = Table3::find($id);
            $image = asset('images/3.png');
        }

        if ($comercializadores != "") {
            $single_map = $comercializadores;
            $final_coordinate = array();
            $single_address = $single_map->DIRECCION;
            $single_province = $single_map->ISLA;
            $single_zip = $single_map->CP;

            if (($single_map->COORDENADA_X == null || $single_map->COORDENADA_X == "") && ($single_map->COORDENADA_Y == null || $single_map->COORDENADA_Y == "")) {
                $results = app('geocoder')->geocode($single_address.','.$single_province)->get();
                $length_result = count($results);

                if ($length_result > 0) {
                    $coordinates = $results->first()->getCoordinates();
                    $coorlng = $coordinates->getLongitude();
                    $coorlat = $coordinates->getLatitude();
                    $final_coordinate = array(
                        'table' => $table,
                        'lng' => $coorlng,
                        'lat' => $coorlat,
                        'icon' => $image
                    );
                    $single_map->COORDENADA_X = $coorlat;
                    $single_map->COORDENADA_Y = $coorlng;
                    $single_map->save();
                } else {
                    $results = app('geocoder')->geocode($single_map->ISLA)->get();

                    $coordinates = $results->first()->getCoordinates();
                    $coorlng = $coordinates->getLongitude();
                    $coorlat = $coordinates->getLatitude();
                    $final_coordinate = array(
                        'table' => $table,
                        'lng' => $coorlng,
                        'lat' => $coorlat,
                        'icon' => $image
                    );
                }
            } else {
                $final_coordinate = array(
                    'table' => $table,
                    'lng' => $single_map->COORDENADA_Y,
                    'lat' => $single_map->COORDENADA_X,
                    'icon' => $image
                );
            }
            return view('result', ['coordinator' => $final_coordinate, 'real_data' => $single_map]);
        }
        return back();
    }

    public function getMunicipiosArray()
    {
        $total_municipios = array();
        $ready_array1 = Table1::all();
        $ready_array2 = Table2::all();
        $ready_array3 = Table3::all();

        foreach ($ready_array1 as $single_array) {
            if (!in_array($single_array->MUNICIPIO, $total_municipios)) {
                array_push($total_municipios, $single_array->MUNICIPIO);
            }
        }
        foreach ($ready_array2 as $single_array) {
            if (!in_array($single_array->MUNICIPIO, $total_municipios)) {
                array_push($total_municipios, $single_array->MUNICIPIO);
            }
        }
        foreach ($ready_array3 as $single_array) {
            if (!in_array($single_array->MUNICIPIO, $total_municipios)) {
                array_push($total_municipios, $single_array->MUNICIPIO);
            }
        }

        return $total_municipios;
    }

    public function getIslassArray()
    {
        $total_islass = array();
        $ready_array1 = Table1::all();
        $ready_array2 = Table2::all();
        $ready_array3 = Table3::all();

        foreach ($ready_array1 as $single_array) {
            if (!in_array($single_array->ISLA, $total_islass)) {
                array_push($total_islass, $single_array->ISLA);
            }
        }
        foreach ($ready_array2 as $single_array) {
            if (!in_array($single_array->ISLA, $total_islass)) {
                array_push($total_islass, $single_array->ISLA);
            }
        }
        foreach ($ready_array3 as $single_array) {
            if (!in_array($single_array->ISLA, $total_islass)) {
                array_push($total_islass, $single_array->ISLA);
            }
        }

        return $total_islass;
    }

    public function getProvinceArray()
    {
        $total_province = array();
        $ready_array1 = Table1::all();
        $ready_array2 = Table2::all();
        $ready_array3 = Table3::all();

        foreach ($ready_array1 as $single_array) {
            if (!in_array($single_array->PROVINCIA, $total_province)) {
                array_push($total_province, $single_array->PROVINCIA);
            }
        }
        foreach ($ready_array2 as $single_array) {
            if (!in_array($single_array->PROVINCIA, $total_province)) {
                array_push($total_province, $single_array->PROVINCIA);
            }
        }
        foreach ($ready_array3 as $single_array) {
            if (!in_array($single_array->PROVINCIA, $total_province)) {
                array_push($total_province, $single_array->PROVINCIA);
            }
        }

        return $total_province;
    }

    public function getProductosArray()
    {
        $total_productos = array();
        $ready_array3 = Table3::all();
        foreach ($ready_array3 as $single_array) {
            $productos_data_array = explode(',', $single_array->PRODUCTOS);
            foreach ($productos_data_array as $single_productos) {
                if (!in_array($single_productos, $total_productos)) {
                    array_push($total_productos, $single_productos);
                }
            }
        }

        return $total_productos;
    }

}
