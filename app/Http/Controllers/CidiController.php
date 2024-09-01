<?php

namespace App\Http\Controllers;

use App\Models\Domicilio;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CidiController extends Controller
{
    public function validarUsuarioCidi()
    {
        // Credenciales obtenidas de las variables de entorno
        $idAplicacion = env('CIDI_ID_APLICACION');
        $password = env('CIDI_PASSWORD');
        $tokenValue = env('CIDI_TOKEN_VALUE');
        $timestamp = env('CIDI_TIMESTAMP');
        $urlCidi = env('CIDI_URL_PETICION');

        // Obtener el valor de la query 'cidi' y almacenarlo como hashCookie
        $hashCookie = request('cidi');

        // Verificar si existe la query 'cidi'
        if ($hashCookie != null) {
            // Cuerpo de la solicitud
            $body = [
                'IdAplicacion' => $idAplicacion,
                'Contrasenia' => $password,
                'HashCookie' => $hashCookie,
                'TokenValue' => $tokenValue,
                'TimeStamp' => $timestamp,
            ];

            // Hacer la petición POST a la API de CIDI
            $response = Http::post($urlCidi, $body);

            // Convertir la respuesta en un array
            $responseFormatted = $response->json();

            // Verificar que la validación sea correcta
            if (isset($responseFormatted['Respuesta']['Resultado']) && $responseFormatted['Respuesta']['Resultado'] === 'OK') {
                // Obtener los datos de la dirección
                $direccionData = [
                    'pais' => $responseFormatted['Domicilio']['Pais'] ?? null,
                    'provincia' => $responseFormatted['Domicilio']['Provincia'] ?? null,
                    'departamento' => $responseFormatted['Domicilio']['Departamento'] ?? null,
                    'localidad' => $responseFormatted['Domicilio']['Localidad'] ?? null,
                    'barrio' => $responseFormatted['Domicilio']['Barrio'] ?? null,
                    'calle' => $responseFormatted['Domicilio']['Calle'] ?? null,
                    'numero' => $responseFormatted['Domicilio']['Altura'] ?? null,
                    'codigo_postal' => $responseFormatted['Domicilio']['CodigoPostal'] ?? null,
                    'piso' => $responseFormatted['Domicilio']['Piso'] ?? null,
                    'depto' => $responseFormatted['Domicilio']['Depto'] ?? null,
                    'torre' => $responseFormatted['Domicilio']['Torre'] ?? null,
                    'manzana' => $responseFormatted['Domicilio']['Manzana'] ?? null,
                    'lote' => $responseFormatted['Domicilio']['Lote'] ?? null,
                ];

                // Buscar una dirección existente que coincida con los campos clave
                $existingDireccion = Domicilio::where('localidad', $direccionData['localidad'])
                    ->where('barrio', $direccionData['barrio'])
                    ->where('calle', $direccionData['calle'])
                    ->where('numero', $direccionData['numero'])
                    ->where('codigo_postal', $direccionData['codigo_postal'])
                    ->first();

                if (!$existingDireccion) {
                    // Crear nueva dirección si no existe
                    $existingDireccion = Domicilio::create($direccionData);
                } else {
                    // Actualizar dirección si existe
                    $existingDireccion->update($direccionData);
                }

                // Obtener los datos de la persona
                $personaData = [
                    'nombre' => $responseFormatted['Nombre'] ?? null,
                    'apellido' => $responseFormatted['Apellido'] ?? null,
                    'nombre_formateado' => $responseFormatted['NombreFormateado'] ?? null,
                    'nombre_autopercibido' => $responseFormatted['NombreAutopercibido'] ?? null,
                    'fecha_nacimiento' => $responseFormatted['FechaNacimiento'] ?? null,
                    'cuil' => $responseFormatted['CUIL'] ?? null,
                    'cuil_formateado' => $responseFormatted['CuilFormateado'] ?? null,
                    'estado' => $responseFormatted['Estado'] ?? null,
                    'telefono_area' => $responseFormatted['TelArea'] ?? null,
                    'telefono_numero' => $responseFormatted['TelNro'] ?? null,
                    'telefono_formateado' => $responseFormatted['TelFormateado'] ?? null,
                    'celular_area' => $responseFormatted['CelArea'] ?? null,
                    'celular_numero' => $responseFormatted['CelNro'] ?? null,
                    'celular_formateado' => $responseFormatted['CelFormateado'] ?? null,
                    'direccion_id' => $existingDireccion->id,
                ];

                // Crear o actualizar el registro de persona
                $persona = Persona::updateOrCreate(['cuil' => $personaData['cuil']], $personaData);
                $email = $responseFormatted['Email'] ?? null;
                $user = User::updateOrCreate(['email' => $email], ['persona_id' => $persona->id]);

                // Autenticar al usuario
                Auth::login($user);

                Session::flash('success', 'Has iniciado sesión con éxito usando CIDI.');
                return redirect()->route('index');
            } else {
                // Devolver el mensaje de error si el resultado no es 'OK'
                return response()->json([
                    'error' => $responseFormatted['Respuesta']['Resultado'],
                    'codigo_error' => $responseFormatted['Respuesta']['CodigoError'] ?? null
                ], 400);
            }
        }

        return view('home');
    }

    public function index()
    {
        return view('index');
    }

    public function logout()
    {
        // Cerrar sesión del usuario
        Auth::logout();

        Session::flash('success', 'Has cerrado sesión exitosamente.');
        // Redirigir al usuario a la página de inicio de sesión o a otra página
        return redirect()->route('login');
    }
}

// return response()->json($responseFormatted);
