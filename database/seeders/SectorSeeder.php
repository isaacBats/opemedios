<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2020
  * @version 1.0.0
  * @package App\
  * Type: Seeder
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Sector::insert([
            ['name' => 'CULTURA', 'description' => 'NULL', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'ELECTRÓNICO', 'description' => 'El sector electr�nico se centra en aparatos o componentes que procesan alg�n tipo de informaci�n. Esta industria se divide en cinco grandes subsectores: audio y video, computaci�n y oficina', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'TRANSPORTE', 'description' => 'Se incluyen todos los medios de transporte de carga y de personas', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'TELECOMUNICACIONES', 'description' => 'Todo lo relacionado con telefon�a m�vil y fija, c�maras del sector, declaraciones de funcionarios del sector', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'CONSTRUCCION', 'description' => 'Cementeras, constructoras y todo lo relacionado con este sector', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_SEGURIDAD', 'description' => 'No existe un modelo único para el sector de la seguridad. Sin embargo, las Naciones Unidas consideran que normalmente este incluye las estructuras, las instituciones y el personal responsable', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'DEPORTES', 'description' => 'Selecci�n nacional de futbol, eventos deportivos, presentaciones de marcas deportivas. (F�ttbol, box, atletismo', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_CASAS DE EMPEÑO', 'description' => ' pinorantes, Nacional Monte de Piedad, empe�os, otras cassa de empeño', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'INDUSTRIA PESQUERA', 'description' => 'ALIMENTOS DEL MAR Y LAGOS. PESCA', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'SALUD', 'description' => 'Enfermedades, medicinas, sobrepeso, cuidado de la piel y el cabello. Art�culos para el cuidado y arreglo personal (Perfumes, cosm�ticos, cremas, lociones', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'ESPECTÁCULOS', 'description' => ' ESPECT�CULOS', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'CULTURA Y ENTRETENIMIENTO', 'description' => 'Museos, cine, exposiciones, libros, revistas, conciertos, series de televisi�n. Notas del espect�culo', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'CUIDADO PERSONAL', 'description' => 'Perfumes, cosm�ticos, cremas, lociones', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'TEXTIL', 'description' => 'La industria textil agrupa todas aquellas actividades dedicadas a la fabricaci�n y obtenci�n de fibras, hilado, tejido, tintado, y finalmente el acabado y confecci�n de las distintas prendas', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'COMBUSTIBLES', 'description' => 'Bioetanol, etanol, biocombustibles, gasolinas, nuevos combustibles, nuevas fuentes de energ��a', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'MEDIO AMBIENTE', 'description' => 'Cuidado del agua, reforestaci�n, agua contaminada, temperatura ambiente', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_LABORATORIOS MEDICOS', 'description' => 'Diferentes laboratorios, lanzamiento de nuevos medicamentos, entrevistas con funcionarios de algún laboratorio', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_MOVIMIENTOS SOCIALES', 'description' => 'Marchas, plantones, mítines', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'TURÚSTICO Y RESTAURANTERO', 'description' => ' Destinos tur��sticos, resorts, playas, declaraciones de funcionarios de la Secretar�a de Turismo. Industria restaurantera', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'VINOS Y LICORES', 'description' => 'Bebidas con alcohol: vino tinto, vino blanco, tequila, brandy, coñac, champagne, mezcal', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'POLITICO', 'description' => 'Declaraciones de funcionarios gubernamentales, estatales y federales', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'AGUAS EMBOTELLADAS Y BEBIDAS', 'description' => 'Diferentes marcas de aguas embotelladas. Refrescos, bebidas energizantes e hidratantes. Nuevos productos, publicidad', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'ARTESANÍAS, ARTÍCULOS DE REGALO Y DECORATIVOS', 'description' => ' Este sector lo integran los sectores textil y confecci�n; cuero y calzado; joyer�a y art��culos de regalo; y art��culos de decoraci�n y muebles.', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_FINANZAS', 'description' => 'Noticias de las diferentes bolsa, tipos de cambio', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_CHIAPAS', 'description' => 'Todo lo Relacionado al Estado de Chiapas, Gobernador, Política, Turismo, etc', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'ENTRETENIMIENTO', 'description' => 'ENTRETENIMIENTO', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_GENERAL', 'description' => 'ESTE SECTOR NO DEBE USARSE. NO HAY NOTICIA QUE SEA GENERAL. SIEMPRE CORRESPONDE A OTRA COSA', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_LA 1260 MEJORANDO TU VIDA', 'description' => 'FAVOR DE NO USAR ESTO', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_LA 1260 (Dr. José Obeid', 'description' => 'FAVOR DE NO USAR ESTO', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_LINDOS SUEÑOS', 'description' => 'Sexualidad', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_sexualidad', 'description' => 'sexualidad', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_capital infantil', 'description' => 'FAVOR DE NO USAR ESTE SECTOR', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_MUSEOS', 'description' => 'MUSEOS', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_DE REVISTA', 'description' => 'FAVOR DE NO USAR ESTO', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_NOTICIAS', 'description' => 'FAVOR DE NO USAR ESTE CALIFICAR ASI LAS NOTAS', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_JOYERO', 'description' => 'Joyería', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'ELECTRODOMESTICOS', 'description' => 'El sector de electrodom�sticos incluye cualquier aparato, utensilio o m�quina usado en el hogar, que utilice electricidad como fuente de energ�a.', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_AEROLINEAS', 'description' => 'AEROPUERTOS, AEROLINEAS, AERONAUTICA', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_Negocios', 'description' => 'Negocios en general', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_SONORA', 'description' => 'SONORA', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_TECNOLOGÍA', 'description' => 'T', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_EDUCACIÓN', 'description' => ' EDUCACI�N', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'SERVICIOS', 'description' => 'Agrupan una serie de actividades que proporcionan comodidad o bienestar a las personas, por ejemplo: la consulta m�dica que ofrece un doctor, las clases que dan los maestros', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_KENA TE REGALA', 'description' => 'S', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_DOMINGO', 'description' => 'SUPLEMENTO', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_JURÍDICO', 'description' => 'Asuntos legales', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_TIENDAS DEPARTAMENTALES', 'description' => 'Servicios', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_FILANTROPÍA', 'description' => 'No utilizar', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_DURANGO', 'description' => 'Información sobre este estado de la república', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'GENERAL', 'description' => 'GENERAL', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_Restaurantes', 'description' => 'Ind. Restaurantera', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_Livestream.net', 'description' => 'Varios', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_Entrevista', 'description' => 'Varios', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'LIVERPOOL', 'description' => 'Liverpool es la cadena mexicana de almacenes departamentales de mayor cobertura a lo largo del país', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_EL LIBRO ROJO, ESPECIES AMENAZADAS', 'description' => 'MEDIO AMBIENTE', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_Muebles y Decoración', 'description' => 'Tiendas y Productos de esta categoria', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_LITIGIOS', 'description' => 'En el litigio existen dos partes y un bien jurídicamente determinado respecto al cual se da el conflicto de intereses', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_LITERATURA', 'description' => 'Información relacionada con libros', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_Mercadotecnia', 'description' => 'Todo lo relacionado con el mundo de la publicidad y el marketing', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'MINERÍA', 'description' => ' Actividad econ�mica primaria (pues los minerales se toman directamente de la Naturaleza) que se refiere a la exploraci�n y aprovechamiento de los recursos  mineros', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'ECONOMÍA Y FINANZAS', 'description' => ' Noticias de la bolsa, valores, tipos de cambio', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_INFANTIL', 'description' => 'Todo lo relacionado con moda y eventos infantiles', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_FÚTBOL', 'description' => 'FÚTBOL', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_PROMOCIÓN', 'description' => 'PROMOCIÓN', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'BEBIDAS', 'description' => 'BEBIDAS', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_CINE', 'description' => 'CINE', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_BOX', 'description' => 'BOX', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_CORTESÍA', 'description' => 'CORTESÍA', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_REGALO', 'description' => 'REGALO', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_TEATRO', 'description' => 'TEATRO', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_CIENCIA', 'description' => 'CIENCIA', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'CIENCIA Y TECNOLOGÍA', 'description' => ' Actividades de investigaci�n y desarrollo experimental para financiar la investigaci�n b�sica y aplicada, as� como el desarrollo de tecnologico', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'X_MÚSICA', 'description' => 'MÚSICA', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'AGROINDUSTRIA', 'description' => 'Actividades agropecuarias. Alimentos en general. Granos y cereales empaquetados', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'FÚTBOL', 'description' => ' F�TBOL', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'DEPORTES', 'description' => 'DEPORTES', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'LITERATURA', 'description' => 'LITERATURA', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'MODA', 'description' => 'MODA', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'CINE', 'description' => 'CINE', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'MUSEOS', 'description' => 'MUSEOS', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'SEGURIDAD', 'description' => 'SEGURIDAD', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'FILANTROP�A', 'description' => ' FILANTROP�A', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'EDUCACI�N', 'description' => ' Sector dedicado a la educaci�n', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'JUSTICIA', 'description' => 'JUSTICIA', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'TIENDAS DEPARTAMENTALES', 'description' => 'Liverpool. Palacio de Hierro, Sears, Suburbia, Frabricas de Francia, El Puerto de Veracruz, El Corte Ingl�s...Etc', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'PRUEBA', 'description' => 'PRueba', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'JOAQUÍN LÓPEZ DÓRIGA', 'description' => '  NOTICIAS', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'MASCOTAS', 'description' => 'Notas de mascotas. perros, gatos', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'BELLEZA', 'description' => 'Cosméticos, cremas, maquillajes', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'RADIO', 'description' => 'A', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'ALIMENTOS', 'description' => 'ALIMENTOS', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'TURÍSTICO', 'description' => ' fd', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'AUTOMOTRIZ', 'description' => 'AUTOMOTRIZ', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'TURISMO', 'description' => 'NULL', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'SALÓN DE LA FAMA', 'description' => ' DEPORTES', 'active' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'CINE Y EN TRETENIMIENTO', 'description' => 'cine', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'POLÍTICA', 'description' => ' POLÍTICA', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'LIBROS', 'description' => 'LIBROS', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['name' => 'MUSICA', 'description' => 'MUSICA', 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
        ]);
    }
}
