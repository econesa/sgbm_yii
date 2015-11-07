Sistema de Administración de Bienes Muebles

Objetivo Principal
-------------------
Automatizar el libro de control para movimientos de bienes muebles entre dependencias en la Institución


Objetivos Secundarios
----------------------
 - Controlar el inventario de biene muebles de cada dependencia, de forma automática
 - Generar en formato PDF del acta de traspasos de bienes muebles
 - Automatizar el proceso de traspaso de bienes muebles
 - Generar en formato PDF de los formularios B.M. 1, 2, 3 y 4, definidos en la Gaceta Oficial  Nro. 2681 Extraordinario


Descripción breve de los Formularios
---------------------------------------
Formulario B.M.4 - Resumen de la Cuenta de Bienes
	La cuenta de Bienes indica números en cantidad y valor en cuanto a la entrada y salida mensual de bienes muebles 
    
Formulario B.M.3 - Relación de Bienes Faltantes
	Si un bien mueble se ha extraviado o robado, se presenta este formulario, normalmente, en conjunto a una denuncia al Cuerpo de Investigaciones Científicas, Penales y Criminalísticas 
    
Formulario B.M.2 - Relación de Movimiento de Bienes
        Relación mensual de Bienes Entrantes o Salientes en una determinada dependencia
    
Formulario B.M.1 - Inventario de Bienes
	Informe mensual de inventario de bienes en la dependencia.


Descripción breve de traspaso de bienes
----------------------------------------------
 1. El usuario de una dependencia origen indica los bienes muebles a ser trasladado hacia otra dependencia, situación ya previamente acordada entre los correspondientes responsables de las mismas. Este usuario debe indicar en que fecha se efectuara el traslado.
 2. Un usuario autorizado de la depedencia destino recibe el mensaje, lee y confirma en el sistema, si efectivamente coincide con lo acordado
 3. Se genera el acta de traslado, la cual obligatoriamente debe ser impresa y firmada por los responsables 
 4. El sistema actualiza la data correspondiente

En caso de una situación irregular, es posible anular el acta generada y mantenerse el estado correcto del sistema
El sistema audita las operaciones que impliquen un cambio en la data.

Instalación
------------
 - Descargar en un directorio Web
 - Disponer el framework Yii a un nivel inferior de la ruta del proyecto
 - Cargar scripts BD de la carpeta protected/data


Tecnologias implicadas
----------------------
 - PHP
 - Framework Yii 1.1
 - MySQL
 - FPDF
 - JQuery



