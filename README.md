# Calculador Cuotas Diarias Préstamos



![Captura web_8-1-2023_1580_localhost](https://user-images.githubusercontent.com/44457989/211219139-20221e76-cc29-4fc7-a815-14e54e3a8768.jpeg)



<h2>Configuración Inicial</h2>

<p><b>1) Configuración variable global de aplicación:</b> Este proyecto ha sido trabajado bajo el prefijo del puerto número 90. (http://localhost:90/) Por lo cual si usted tiene configurado el mismo con otro puerto, o en su defecto mantiene el estándar original, debe realizar ese cambio; caso contrario los estilos y redirecciones de la aplicación no funcionarán y será imposible el óptimo funcionamiento del mismo.</p>


![carbon](https://user-images.githubusercontent.com/44457989/211219177-575f314e-348f-462e-84a7-39929754c53c.png)


<p><b>2) Configuración importación estilos CSS:</b> Lo mencionado en el primer punto, algunos estilos css son importados mediante una regla especial css. Motivo por el cual usted debe cambiar la URL asignada por defecto a la de su servidor (entiéndase por defecto http://localhost:90/) Por favor ubique el archivo en TablaAmortizacionMensual/css/style.css y realice los cambios pertinentes.</p>



![carbon (1)](https://user-images.githubusercontent.com/44457989/211219211-c87c5b50-4a1d-431c-8dc9-2b6b98cfb8ff.png)



<h2>¿Qué Puedo Realizar?</h2>


<p>Usted puede simular el registro de una solicitud crediticia, y calcular la cuota diaria respectiva más el cálculo de la tasa de interés que usted designe. <b>Por favor tome en cuenta que este sistema realiza el cálculo de la tasa de interés diaria y no anual o mensual, pero perfectamente se puede adecuar a otras necesidades.</b></p>




<h2>¿Deseas probar la demo en vivo?</h2>


<p>Por favor acceda a la siguiente URL y verifique el funcionamiento de este sistema: http://amortizaciondiaria.unaux.com/.<b> No existe el manejo de sesiones. Únicamente debe completar todos los campos solicitados.</b></p>




<h2>Consideraciones</h2>


<p><b>1) Exclusión de domingos:</b> Este sistema realiza un reajuste a las fechas de pago, cuando una fecha de pago corresponda al dia domingo, el sistema esta preparado para sumar en uno la fecha de pago final
y reajustando las consiguientes fechas de pago. Para ello se realizaron algunos procedimientos especiales dentro del código fuente que se detallan a continuación:</p>

<p>* Función que calcula cuantos domingos existen de X a Y fecha del préstamo a otorgar</p>


![carbon (2)](https://user-images.githubusercontent.com/44457989/211219426-a6a4fab2-b8a1-4fcc-b5a6-7967708b5a06.png)


<p>* Calcular el núnero de cuotas a generar en el estado de cuenta, excluyendo completamente los días domingos</p>

![carbon (3)](https://user-images.githubusercontent.com/44457989/211219509-335f6cff-bfe3-476d-aa42-76d513fa4295.png)

<p>* Al momento de generar el respectivo estado de cuenta, sumar la cantidad de domingos excluidos para que el cálculo sea exacto de principio a fin del respectivo estado de cuenta.
Caso contrario los datos no concuerdan.</p>


![carbon (4)](https://user-images.githubusercontent.com/44457989/211219679-b60b7b08-0fe5-4b9e-a619-f4e000e4e419.png)


<p><b>2) Este proyecto es informativo y simula un entorno dónde se podría poner en práctica lo anterior. Sí desea realizar gestiones más específicas, necesita de la conectividad a una base de datos.</b></p>


<p><b>3) Impuesto Agregado:</b> Además de realizar el cálculo en base a la tasa de interés establecida, incluye el impuesto sobre el IVA vigente en El Salvador. El cuál su porcentaje es el 13%.</p>

<h2>Fórmula Matemática</h2>


![carbon (5)](https://user-images.githubusercontent.com/44457989/211219764-04f0d0a2-32e5-4338-992c-62f3b713563e.png)



<h2>Algunas Capturas</h2>

<h3>* Ingreso Solicitudes</h3>



![Captura web_8-1-2023_152511_localhost](https://user-images.githubusercontent.com/44457989/211219866-226996d4-d11d-4db4-94ac-68862c856fc0.jpeg)



<h3>* Muestra Información Final</h3>




![Captura web_8-1-2023_152548_localhost](https://user-images.githubusercontent.com/44457989/211219899-99bbbbe3-c592-4354-9b13-1245e39597f5.jpeg)




<h3>* Vista Impresión</h3>




![Captura de pantalla 2023-01-08 152659](https://user-images.githubusercontent.com/44457989/211219949-dc2993eb-7d1c-40c9-be12-be0add4e3f03.png)




<h3>* Documento PDF - Vista Impresión</h3>



![Captura de pantalla 2023-01-08 152750](https://user-images.githubusercontent.com/44457989/211219990-db4082ca-25a6-4993-bf59-deacbba34f06.png)
![Captura de pantalla 2023-01-08 152808](https://user-images.githubusercontent.com/44457989/211219992-649716d2-54f5-4627-a35e-5bdf234d736f.png)


<h2>Muchas gracias por obtener este repositorio hecho con algunas tazas de café ☕ ❤️</h2>



![poster_5dfe44fc8738c205dc24cc919a7de3fd](https://user-images.githubusercontent.com/44457989/84722426-6d047d80-af40-11ea-8a6d-31b4466c1c08.png)




<h4>*** Fecha de Subida: 08 enero 2023 ***</h4>


