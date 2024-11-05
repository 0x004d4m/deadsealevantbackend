<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert([
            ["id" => 1, "name" => '{"en":"Afghanistan","es":"Afganistán","ar":"أفغانستان","fr":"Afghanistan"}'],
            ["id" => 2, "name" => '{"en":"Albania","es":"Albania","ar":"ألبانيا","fr":"Albanie"}'],
            ["id" => 3, "name" => '{"en":"Algeria","es":"Argelia","ar":"الجزائر","fr":"Algérie"}'],
            ["id" => 4, "name" => '{"en":"Andorra","es":"Andorra","ar":"أندورا","fr":"Andorre"}'],
            ["id" => 5, "name" => '{"en":"Angola","es":"Angola","ar":"أنغولا","fr":"Angola"}'],
            ["id" => 6, "name" => '{"en":"Antigua and Barbuda","es":"Antigua y Barbuda","ar":"أنتيغوا وباربودا","fr":"Antigua-et-Barbuda"}'],
            ["id" => 7, "name" => '{"en":"Argentina","es":"Argentina","ar":"الأرجنتين","fr":"Argentine"}'],
            ["id" => 8, "name" => '{"en":"Armenia","es":"Armenia","ar":"أرمينيا","fr":"Arménie"}'],
            ["id" => 9, "name" => '{"en":"Australia","es":"Australia","ar":"أستراليا","fr":"Australie"}'],
            ["id" => 10, "name" => '{"en":"Austria","es":"Austria","ar":"النمسا","fr":"Autriche"}'],
            ["id" => 11, "name" => '{"en":"Azerbaijan","es":"Azerbaiyán","ar":"أذربيجان","fr":"Azerbaïdjan"}'],
            ["id" => 12, "name" => '{"en":"Bahamas","es":"Bahamas","ar":"جزر البهاما","fr":"Bahamas"}'],
            ["id" => 13, "name" => '{"en":"Bahrain","es":"Baréin","ar":"البحرين","fr":"Bahreïn"}'],
            ["id" => 14, "name" => '{"en":"Bangladesh","es":"Bangladesh","ar":"بنغلاديش","fr":"Bangladesh"}'],
            ["id" => 15, "name" => '{"en":"Barbados","es":"Barbados","ar":"باربادوس","fr":"Barbade"}'],
            ["id" => 16, "name" => '{"en":"Belarus","es":"Bielorrusia","ar":"بيلاروسيا","fr":"Biélorussie"}'],
            ["id" => 17, "name" => '{"en":"Belgium","es":"Bélgica","ar":"بلجيكا","fr":"Belgique"}'],
            ["id" => 18, "name" => '{"en":"Belize","es":"Belice","ar":"بليز","fr":"Belize"}'],
            ["id" => 19, "name" => '{"en":"Benin","es":"Benín","ar":"بنين","fr":"Bénin"}'],
            ["id" => 20, "name" => '{"en":"Bhutan","es":"Bután","ar":"بوتان","fr":"Bhoutan"}'],
            ["id" => 21, "name" => '{"en":"Bolivia","es":"Bolivia","ar":"بوليفيا","fr":"Bolivie"}'],
            ["id" => 22, "name" => '{"en":"Bosnia and Herzegovina","es":"Bosnia y Herzegovina","ar":"البوسنة والهرسك","fr":"Bosnie-Herzégovine"}'],
            ["id" => 23, "name" => '{"en":"Botswana","es":"Botsuana","ar":"بوتسوانا","fr":"Botswana"}'],
            ["id" => 24, "name" => '{"en":"Brazil","es":"Brasil","ar":"البرازيل","fr":"Brésil"}'],
            ["id" => 25, "name" => '{"en":"Brunei","es":"Brunéi","ar":"بروناي","fr":"Brunei"}'],
            ["id" => 26, "name" => '{"en":"Bulgaria","es":"Bulgaria","ar":"بلغاريا","fr":"Bulgarie"}'],
            ["id" => 27, "name" => '{"en":"Burkina Faso","es":"Burkina Faso","ar":"بوركينا فاسو","fr":"Burkina Faso"}'],
            ["id" => 28, "name" => '{"en":"Burundi","es":"Burundi","ar":"بوروندي","fr":"Burundi"}'],
            ["id" => 29, "name" => '{"en":"Cabo Verde","es":"Cabo Verde","ar":"الرأس الأخضر","fr":"Cap-Vert"}'],
            ["id" => 30, "name" => '{"en":"Cambodia","es":"Camboya","ar":"كمبوديا","fr":"Cambodge"}'],
            ["id" => 31, "name" => '{"en":"Cameroon","es":"Camerún","ar":"الكاميرون","fr":"Cameroun"}'],
            ["id" => 32, "name" => '{"en":"Canada","es":"Canadá","ar":"كندا","fr":"Canada"}'],
            ["id" => 33, "name" => '{"en":"Central African Republic","es":"República Centroafricana","ar":"جمهورية أفريقيا الوسطى","fr":"République centrafricaine"}'],
            ["id" => 34, "name" => '{"en":"Chad","es":"Chad","ar":"تشاد","fr":"Tchad"}'],
            ["id" => 35, "name" => '{"en":"Chile","es":"Chile","ar":"تشيلي","fr":"Chili"}'],
            ["id" => 36, "name" => '{"en":"China","es":"China","ar":"الصين","fr":"Chine"}'],
            ["id" => 37, "name" => '{"en":"Colombia","es":"Colombia","ar":"كولومبيا","fr":"Colombie"}'],
            ["id" => 38, "name" => '{"en":"Comoros","es":"Comoras","ar":"جزر القمر","fr":"Comores"}'],
            ["id" => 39, "name" => '{"en":"Congo, Democratic Republic of the","es":"República Democrática del Congo","ar":"جمهورية الكونغو الديمقراطية","fr":"République démocratique du Congo"}'],
            ["id" => 40, "name" => '{"en":"Congo, Republic of the","es":"República del Congo","ar":"جمهورية الكونغو","fr":"République du Congo"}'],
            ["id" => 41, "name" => '{"en":"Costa Rica","es":"Costa Rica","ar":"كوستاريكا","fr":"Costa Rica"}'],
            ["id" => 42, "name" => '{"en":"Croatia","es":"Croacia","ar":"كرواتيا","fr":"Croatie"}'],
            ["id" => 43, "name" => '{"en":"Cuba","es":"Cuba","ar":"كوبا","fr":"Cuba"}'],
            ["id" => 44, "name" => '{"en":"Cyprus","es":"Chipre","ar":"قبرص","fr":"Chypre"}'],
            ["id" => 45, "name" => '{"en":"Czech Republic","es":"República Checa","ar":"جمهورية التشيك","fr":"République tchèque"}'],
            ["id" => 46, "name" => '{"en":"Denmark","es":"Dinamarca","ar":"الدنمارك","fr":"Danemark"}'],
            ["id" => 47, "name" => '{"en":"Djibouti","es":"Yibuti","ar":"جيبوتي","fr":"Djibouti"}'],
            ["id" => 48, "name" => '{"en":"Dominica","es":"Dominica","ar":"دومينيكا","fr":"Dominique"}'],
            ["id" => 49, "name" => '{"en":"Dominican Republic","es":"República Dominicana","ar":"جمهورية الدومينيكان","fr":"République dominicaine"}'],
            ["id" => 50, "name" => '{"en":"Ecuador","es":"Ecuador","ar":"الإكوادور","fr":"Équateur"}'],
            ["id" => 51, "name" => '{"en":"Egypt","es":"Egipto","ar":"مصر","fr":"Égypte"}'],
            ["id" => 52, "name" => '{"en":"El Salvador","es":"El Salvador","ar":"السلفادور","fr":"Salvador"}'],
            ["id" => 53, "name" => '{"en":"Equatorial Guinea","es":"Guinea Ecuatorial","ar":"غينيا الاستوائية","fr":"Guinée équatoriale"}'],
            ["id" => 54, "name" => '{"en":"Eritrea","es":"Eritrea","ar":"إريتريا","fr":"Érythrée"}'],
            ["id" => 55, "name" => '{"en":"Estonia","es":"Estonia","ar":"إستونيا","fr":"Estonie"}'],
            ["id" => 56, "name" => '{"en":"Eswatini","es":"Eswatini","ar":"إسواتيني","fr":"Eswatini"}'],
            ["id" => 57, "name" => '{"en":"Ethiopia","es":"Etiopía","ar":"إثيوبيا","fr":"Éthiopie"}'],
            ["id" => 58, "name" => '{"en":"Fiji","es":"Fiyi","ar":"فيجي","fr":"Fidji"}'],
            ["id" => 59, "name" => '{"en":"Finland","es":"Finlandia","ar":"فنلندا","fr":"Finlande"}'],
            ["id" => 60, "name" => '{"en":"France","es":"Francia","ar":"فرنسا","fr":"France"}'],
            ["id" => 61, "name" => '{"en":"Gabon","es":"Gabón","ar":"الغابون","fr":"Gabon"}'],
            ["id" => 62, "name" => '{"en":"Gambia","es":"Gambia","ar":"غامبيا","fr":"Gambie"}'],
            ["id" => 63, "name" => '{"en":"Georgia","es":"Georgia","ar":"جورجيا","fr":"Géorgie"}'],
            ["id" => 64, "name" => '{"en":"Germany","es":"Alemania","ar":"ألمانيا","fr":"Allemagne"}'],
            ["id" => 65, "name" => '{"en":"Ghana","es":"Ghana","ar":"غانا","fr":"Ghana"}'],
            ["id" => 66, "name" => '{"en":"Greece","es":"Grecia","ar":"اليونان","fr":"Grèce"}'],
            ["id" => 67, "name" => '{"en":"Grenada","es":"Granada","ar":"غرينادا","fr":"Grenade"}'],
            ["id" => 68, "name" => '{"en":"Guatemala","es":"Guatemala","ar":"غواتيمالا","fr":"Guatemala"}'],
            ["id" => 69, "name" => '{"en":"Guinea","es":"Guinea","ar":"غينيا","fr":"Guinée"}'],
            ["id" => 70, "name" => '{"en":"Guinea-Bissau","es":"Guinea-Bisáu","ar":"غينيا بيساو","fr":"Guinée-Bissau"}'],
            ["id" => 71, "name" => '{"en":"Guyana","es":"Guyana","ar":"غيانا","fr":"Guyana"}'],
            ["id" => 72, "name" => '{"en":"Haiti","es":"Haití","ar":"هايتي","fr":"Haïti"}'],
            ["id" => 73, "name" => '{"en":"Honduras","es":"Honduras","ar":"هندوراس","fr":"Honduras"}'],
            ["id" => 74, "name" => '{"en":"Hungary","es":"Hungría","ar":"المجر","fr":"Hongrie"}'],
            ["id" => 75, "name" => '{"en":"Iceland","es":"Islandia","ar":"آيسلندا","fr":"Islande"}'],
            ["id" => 76, "name" => '{"en":"India","es":"India","ar":"الهند","fr":"Inde"}'],
            ["id" => 77, "name" => '{"en":"Indonesia","es":"Indonesia","ar":"إندونيسيا","fr":"Indonésie"}'],
            ["id" => 78, "name" => '{"en":"Iran","es":"Irán","ar":"إيران","fr":"Iran"}'],
            ["id" => 79, "name" => '{"en":"Iraq","es":"Irak","ar":"العراق","fr":"Irak"}'],
            ["id" => 80, "name" => '{"en":"Ireland","es":"Irlanda","ar":"أيرلندا","fr":"Irlande"}'],
            ["id" => 81, "name" => '{"en":"Israel","es":"Israel","ar":"إسرائيل","fr":"Israël"}'],
            ["id" => 82, "name" => '{"en":"Italy","es":"Italia","ar":"إيطاليا","fr":"Italie"}'],
            ["id" => 83, "name" => '{"en":"Jamaica","es":"Jamaica","ar":"جامايكا","fr":"Jamaïque"}'],
            ["id" => 84, "name" => '{"en":"Japan","es":"Japón","ar":"اليابان","fr":"Japon"}'],
            ["id" => 85, "name" => '{"en":"Jordan","es":"Jordania","ar":"الأردن","fr":"Jordanie"}'],
            ["id" => 86, "name" => '{"en":"Kazakhstan","es":"Kazajistán","ar":"كازاخستان","fr":"Kazakhstan"}'],
            ["id" => 87, "name" => '{"en":"Kenya","es":"Kenia","ar":"كينيا","fr":"Kenya"}'],
            ["id" => 88, "name" => '{"en":"Kiribati","es":"Kiribati","ar":"كيريباتي","fr":"Kiribati"}'],
            ["id" => 89, "name" => '{"en":"Korea, North","es":"Corea del Norte","ar":"كوريا الشمالية","fr":"Corée du Nord"}'],
            ["id" => 90, "name" => '{"en":"Korea, South","es":"Corea del Sur","ar":"كوريا الجنوبية","fr":"Corée du Sud"}'],
            ["id" => 91, "name" => '{"en":"Kuwait","es":"Kuwait","ar":"الكويت","fr":"Koweït"}'],
            ["id" => 92, "name" => '{"en":"Kyrgyzstan","es":"Kirguistán","ar":"قيرغيزستان","fr":"Kirghizistan"}'],
            ["id" => 93, "name" => '{"en":"Laos","es":"Laos","ar":"لاوس","fr":"Laos"}'],
            ["id" => 94, "name" => '{"en":"Latvia","es":"Letonia","ar":"لاتفيا","fr":"Lettonie"}'],
            ["id" => 95, "name" => '{"en":"Lebanon","es":"Líbano","ar":"لبنان","fr":"Liban"}'],
            ["id" => 96, "name" => '{"en":"Lesotho","es":"Lesoto","ar":"ليسوتو","fr":"Lesotho"}'],
            ["id" => 97, "name" => '{"en":"Liberia","es":"Liberia","ar":"ليبيريا","fr":"Liberia"}'],
            ["id" => 98, "name" => '{"en":"Libya","es":"Libia","ar":"ليبيا","fr":"Libye"}'],
            ["id" => 99, "name" => '{"en":"Liechtenstein","es":"Liechtenstein","ar":"ليختنشتاين","fr":"Liechtenstein"}'],
            ["id" => 100, "name" => '{"en":"Lithuania","es":"Lituania","ar":"ليتوانيا","fr":"Lituanie"}'],
            ["id" => 101, "name" => '{"en":"Luxembourg","es":"Luxemburgo","ar":"لوكسمبورغ","fr":"Luxembourg"}'],
            ["id" => 102, "name" => '{"en":"Madagascar","es":"Madagascar","ar":"مدغشقر","fr":"Madagascar"}'],
            ["id" => 103, "name" => '{"en":"Malawi","es":"Malaui","ar":"مالاوي","fr":"Malawi"}'],
            ["id" => 104, "name" => '{"en":"Malaysia","es":"Malasia","ar":"ماليزيا","fr":"Malaisie"}'],
            ["id" => 105, "name" => '{"en":"Maldives","es":"Maldivas","ar":"جزر المالديف","fr":"Maldives"}'],
            ["id" => 106, "name" => '{"en":"Mali","es":"Malí","ar":"مالي","fr":"Mali"}'],
            ["id" => 107, "name" => '{"en":"Malta","es":"Malta","ar":"مالطا","fr":"Malte"}'],
            ["id" => 108, "name" => '{"en":"Marshall Islands","es":"Islas Marshall","ar":"جزر مارشال","fr":"Îles Marshall"}'],
            ["id" => 109, "name" => '{"en":"Mauritania","es":"Mauritania","ar":"موريتانيا","fr":"Mauritanie"}'],
            ["id" => 110, "name" => '{"en":"Mauritius","es":"Mauricio","ar":"موريشيوس","fr":"Maurice"}'],
            ["id" => 111, "name" => '{"en":"Mexico","es":"México","ar":"المكسيك","fr":"Mexique"}'],
            ["id" => 112, "name" => '{"en":"Micronesia","es":"Micronesia","ar":"ميكرونيزيا","fr":"Micronésie"}'],
            ["id" => 113, "name" => '{"en":"Moldova","es":"Moldavia","ar":"مولدوفا","fr":"Moldavie"}'],
            ["id" => 114, "name" => '{"en":"Monaco","es":"Mónaco","ar":"موناكو","fr":"Monaco"}'],
            ["id" => 115, "name" => '{"en":"Mongolia","es":"Mongolia","ar":"منغوليا","fr":"Mongolie"}'],
            ["id" => 116, "name" => '{"en":"Montenegro","es":"Montenegro","ar":"الجبل الأسود","fr":"Monténégro"}'],
            ["id" => 117, "name" => '{"en":"Morocco","es":"Marruecos","ar":"المغرب","fr":"Maroc"}'],
            ["id" => 118, "name" => '{"en":"Mozambique","es":"Mozambique","ar":"موزمبيق","fr":"Mozambique"}'],
            ["id" => 119, "name" => '{"en":"Myanmar","es":"Myanmar","ar":"ميانمار","fr":"Myanmar"}'],
            ["id" => 120, "name" => '{"en":"Namibia","es":"Namibia","ar":"ناميبيا","fr":"Namibie"}'],
            ["id" => 121, "name" => '{"en":"Nauru","es":"Nauru","ar":"ناورو","fr":"Nauru"}'],
            ["id" => 122, "name" => '{"en":"Nepal","es":"Nepal","ar":"نيبال","fr":"Népal"}'],
            ["id" => 123, "name" => '{"en":"Netherlands","es":"Países Bajos","ar":"هولندا","fr":"Pays-Bas"}'],
            ["id" => 124, "name" => '{"en":"New Zealand","es":"Nueva Zelanda","ar":"نيوزيلندا","fr":"Nouvelle-Zélande"}'],
            ["id" => 125, "name" => '{"en":"Nicaragua","es":"Nicaragua","ar":"نيكاراغوا","fr":"Nicaragua"}'],
            ["id" => 126, "name" => '{"en":"Niger","es":"Níger","ar":"النيجر","fr":"Niger"}'],
            ["id" => 127, "name" => '{"en":"Nigeria","es":"Nigeria","ar":"نيجيريا","fr":"Nigeria"}'],
            ["id" => 128, "name" => '{"en":"North Macedonia","es":"Macedonia del Norte","ar":"مقدونيا الشمالية","fr":"Macédoine du Nord"}'],
            ["id" => 129, "name" => '{"en":"Norway","es":"Noruega","ar":"النرويج","fr":"Norvège"}'],
            ["id" => 130, "name" => '{"en":"Oman","es":"Omán","ar":"عمان","fr":"Oman"}'],
            ["id" => 131, "name" => '{"en":"Pakistan","es":"Pakistán","ar":"باكستان","fr":"Pakistan"}'],
            ["id" => 132, "name" => '{"en":"Palau","es":"Palaos","ar":"بالاو","fr":"Palaos"}'],
            ["id" => 133, "name" => '{"en":"Panama","es":"Panamá","ar":"بنما","fr":"Panama"}'],
            ["id" => 134, "name" => '{"en":"Papua New Guinea","es":"Papúa Nueva Guinea","ar":"بابوا غينيا الجديدة","fr":"Papouasie-Nouvelle-Guinée"}'],
            ["id" => 135, "name" => '{"en":"Paraguay","es":"Paraguay","ar":"باراغواي","fr":"Paraguay"}'],
            ["id" => 136, "name" => '{"en":"Peru","es":"Perú","ar":"بيرو","fr":"Pérou"}'],
            ["id" => 137, "name" => '{"en":"Philippines","es":"Filipinas","ar":"الفلبين","fr":"Philippines"}'],
            ["id" => 138, "name" => '{"en":"Poland","es":"Polonia","ar":"بولندا","fr":"Pologne"}'],
            ["id" => 139, "name" => '{"en":"Portugal","es":"Portugal","ar":"البرتغال","fr":"Portugal"}'],
            ["id" => 140, "name" => '{"en":"Qatar","es":"Catar","ar":"قطر","fr":"Qatar"}'],
            ["id" => 141, "name" => '{"en":"Romania","es":"Rumania","ar":"رومانيا","fr":"Roumanie"}'],
            ["id" => 142, "name" => '{"en":"Russia","es":"Rusia","ar":"روسيا","fr":"Russie"}'],
            ["id" => 143, "name" => '{"en":"Rwanda","es":"Ruanda","ar":"رواندا","fr":"Rwanda"}'],
            ["id" => 144, "name" => '{"en":"Saint Kitts and Nevis","es":"San Cristóbal y Nieves","ar":"سانت كيتس ونيفيس","fr":"Saint-Christophe-et-Niévès"}'],
            ["id" => 145, "name" => '{"en":"Saint Lucia","es":"Santa Lucía","ar":"سانت لوسيا","fr":"Sainte-Lucie"}'],
            ["id" => 146, "name" => '{"en":"Saint Vincent and the Grenadines","es":"San Vicente y las Granadinas","ar":"سانت فينسنت وجزر غرينادين","fr":"Saint-Vincent-et-les-Grenadines"}'],
            ["id" => 147, "name" => '{"en":"Samoa","es":"Samoa","ar":"ساموا","fr":"Samoa"}'],
            ["id" => 148, "name" => '{"en":"San Marino","es":"San Marino","ar":"سان مارينو","fr":"Saint-Marin"}'],
            ["id" => 149, "name" => '{"en":"Sao Tome and Principe","es":"Santo Tomé y Príncipe","ar":"ساو تومي وبرينسيبي","fr":"Sao Tomé-et-Principe"}'],
            ["id" => 150, "name" => '{"en":"Saudi Arabia","es":"Arabia Saudita","ar":"المملكة العربية السعودية","fr":"Arabie Saoudite"}'],
            ["id" => 151, "name" => '{"en":"Senegal","es":"Senegal","ar":"السنغال","fr":"Sénégal"}'],
            ["id" => 152, "name" => '{"en":"Serbia","es":"Serbia","ar":"صربيا","fr":"Serbie"}'],
            ["id" => 153, "name" => '{"en":"Seychelles","es":"Seychelles","ar":"سيشيل","fr":"Seychelles"}'],
            ["id" => 154, "name" => '{"en":"Sierra Leone","es":"Sierra Leona","ar":"سيراليون","fr":"Sierra Leone"}'],
            ["id" => 155, "name" => '{"en":"Singapore","es":"Singapur","ar":"سنغافورة","fr":"Singapour"}'],
            ["id" => 156, "name" => '{"en":"Slovakia","es":"Eslovaquia","ar":"سلوفاكيا","fr":"Slovaquie"}'],
            ["id" => 157, "name" => '{"en":"Slovenia","es":"Eslovenia","ar":"سلوفينيا","fr":"Slovénie"}'],
            ["id" => 158, "name" => '{"en":"Solomon Islands","es":"Islas Salomón","ar":"جزر سليمان","fr":"Îles Salomon"}'],
            ["id" => 159, "name" => '{"en":"Somalia","es":"Somalia","ar":"الصومال","fr":"Somalie"}'],
            ["id" => 160, "name" => '{"en":"South Africa","es":"Sudáfrica","ar":"جنوب أفريقيا","fr":"Afrique du Sud"}'],
            ["id" => 161, "name" => '{"en":"South Sudan","es":"Sudán del Sur","ar":"جنوب السودان","fr":"Soudan du Sud"}'],
            ["id" => 162, "name" => '{"en":"Spain","es":"España","ar":"إسبانيا","fr":"Espagne"}'],
            ["id" => 163, "name" => '{"en":"Sri Lanka","es":"Sri Lanka","ar":"سريلانكا","fr":"Sri Lanka"}'],
            ["id" => 164, "name" => '{"en":"Sudan","es":"Sudán","ar":"السودان","fr":"Soudan"}'],
            ["id" => 165, "name" => '{"en":"Suriname","es":"Surinam","ar":"سورينام","fr":"Suriname"}'],
            ["id" => 166, "name" => '{"en":"Sweden","es":"Suecia","ar":"السويد","fr":"Suède"}'],
            ["id" => 167, "name" => '{"en":"Switzerland","es":"Suiza","ar":"سويسرا","fr":"Suisse"}'],
            ["id" => 168, "name" => '{"en":"Syria","es":"Siria","ar":"سوريا","fr":"Syrie"}'],
            ["id" => 169, "name" => '{"en":"Taiwan","es":"Taiwán","ar":"تايوان","fr":"Taïwan"}'],
            ["id" => 170, "name" => '{"en":"Tajikistan","es":"Tayikistán","ar":"طاجيكستان","fr":"Tadjikistan"}'],
            ["id" => 171, "name" => '{"en":"Tanzania","es":"Tanzania","ar":"تنزانيا","fr":"Tanzanie"}'],
            ["id" => 172, "name" => '{"en":"Thailand","es":"Tailandia","ar":"تايلاند","fr":"Thaïlande"}'],
            ["id" => 173, "name" => '{"en":"Timor-Leste","es":"Timor-Leste","ar":"تيمور الشرقية","fr":"Timor-Leste"}'],
            ["id" => 174, "name" => '{"en":"Togo","es":"Togo","ar":"توغو","fr":"Togo"}'],
            ["id" => 175, "name" => '{"en":"Tonga","es":"Tonga","ar":"تونغا","fr":"Tonga"}'],
            ["id" => 176, "name" => '{"en":"Trinidad and Tobago","es":"Trinidad y Tobago","ar":"ترينيداد وتوباغو","fr":"Trinité-et-Tobago"}'],
            ["id" => 177, "name" => '{"en":"Tunisia","es":"Túnez","ar":"تونس","fr":"Tunisie"}'],
            ["id" => 178, "name" => '{"en":"Turkey","es":"Turquía","ar":"تركيا","fr":"Turquie"}'],
            ["id" => 179, "name" => '{"en":"Turkmenistan","es":"Turkmenistán","ar":"تركمانستان","fr":"Turkménistan"}'],
            ["id" => 180, "name" => '{"en":"Tuvalu","es":"Tuvalu","ar":"توفالو","fr":"Tuvalu"}'],
            ["id" => 181, "name" => '{"en":"Uganda","es":"Uganda","ar":"أوغندا","fr":"Ouganda"}'],
            ["id" => 182, "name" => '{"en":"Ukraine","es":"Ucrania","ar":"أوكرانيا","fr":"Ukraine"}'],
            ["id" => 183, "name" => '{"en":"United Arab Emirates","es":"Emiratos Árabes Unidos","ar":"الإمارات العربية المتحدة","fr":"Émirats arabes unis"}'],
            ["id" => 184, "name" => '{"en":"United Kingdom","es":"Reino Unido","ar":"المملكة المتحدة","fr":"Royaume-Uni"}'],
            ["id" => 185, "name" => '{"en":"United States","es":"Estados Unidos","ar":"الولايات المتحدة","fr":"États-Unis"}'],
            ["id" => 186, "name" => '{"en":"Uruguay","es":"Uruguay","ar":"أوروغواي","fr":"Uruguay"}'],
            ["id" => 187, "name" => '{"en":"Uzbekistan","es":"Uzbekistán","ar":"أوزبكستان","fr":"Ouzbékistan"}'],
            ["id" => 188, "name" => '{"en":"Vanuatu","es":"Vanuatu","ar":"فانواتو","fr":"Vanuatu"}'],
            ["id" => 189, "name" => '{"en":"Vatican City","es":"Ciudad del Vaticano","ar":"مدينة الفاتيكان","fr":"Cité du Vatican"}'],
            ["id" => 190, "name" => '{"en":"Venezuela","es":"Venezuela","ar":"فنزويلا","fr":"Venezuela"}'],
            ["id" => 191, "name" => '{"en":"Vietnam","es":"Vietnam","ar":"فيتنام","fr":"Vietnam"}'],
            ["id" => 192, "name" => '{"en":"Yemen","es":"Yemen","ar":"اليمن","fr":"Yémen"}'],
            ["id" => 193, "name" => '{"en":"Zambia","es":"Zambia","ar":"زامبيا","fr":"Zambie"}'],
            ["id" => 194, "name" => '{"en":"Zimbabwe","es":"Zimbabue","ar":"زيمبابوي","fr":"Zimbabwe"}']
        ]);
    }
}
