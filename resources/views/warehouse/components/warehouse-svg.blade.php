<div class="warehouse-canvas">

<svg
id="warehouseMap"
viewBox="0 0 1500 1120"
width="100%"
height="100%">

<!-- ==========================================
FONDO
========================================== -->

<rect
x="0"
y="0"
width="1500"
height="900"
rx="18"
fill="#f8fafc"/>

<!-- ==========================================
BORDE DEL ALMACÉN
========================================== -->

<rect
x="40"
y="90"
width="1330"
height="990"
rx="6"
fill="white"
stroke="#202938"
stroke-width="6"/>

<!-- ==========================================
TÍTULO
========================================== -->

<text
x="60"
y="55"
font-size="34"
font-weight="700"
fill="#0f172a">

Mapa Visual del Almacén

</text>

<text
x="60"
y="85"
font-size="18"
fill="#64748b">

Vista general de ubicaciones y stock

</text>

<!-- ==========================================
NIVEL 2
========================================== -->

<rect

x="70"
y="115"

width="95"
height="36"

rx="8"

fill="#2563eb"/>

<text

x="118"

y="140"

text-anchor="middle"

font-size="20"

fill="white"

font-weight="700">

NIVEL 2

</text>

<!-- ==========================================
RACK A
========================================== -->

<g
id="rackA2"
class="warehouse-rack"
data-rack="A"
onclick="abrirRack('A')">

<rect

class="rack"

x="80"

y="170"

width="210"

height="340"

rx="8"/>

<rect

x="110"

y="170"

width="70"

height="18"

rx="4"

fill="#2563eb"/>

<text

x="185"

y="330"

text-anchor="middle"

font-size="24"

font-weight="700"

fill="#1d4ed8">

RACK A

</text>

</g>

<!-- ==========================================
RACK B
========================================== -->

<g
id="rackB2"
class="warehouse-rack"
data-rack="B"
onclick="abrirRack('B')">

<rect

class="rack"

x="320"

y="170"

width="210"

height="340"

rx="8"/>

<rect

x="350"

y="170"

width="70"

height="18"

rx="4"

fill="#2563eb"/>

<text

x="425"

y="330"

text-anchor="middle"

font-size="24"

font-weight="700"

fill="#1d4ed8">

RACK B

</text>

</g>

<!-- ==========================================
PASILLO
========================================== -->

<line

x1="565"

y1="170"

x2="565"

y2="530"

stroke="#bfc5ce"

stroke-width="2"

stroke-dasharray="12 12"/>

<line

x1="625"

y1="170"

x2="625"

y2="530"

stroke="#bfc5ce"

stroke-width="2"

stroke-dasharray="12 12"/>

<text

x="595"

y="360"

transform="rotate(90 595 360)"

text-anchor="middle"

font-size="20"

font-weight="700"

fill="#475569">

PASILLO

</text>

<!-- ==========================================
RACK C
========================================== -->

<g
id="rackC2"
class="warehouse-rack"
data-rack="C"
onclick="abrirRack('C')">

<rect

class="rack"

x="660"

y="170"

width="210"

height="340"

rx="8"/>

<rect

x="690"

y="170"

width="70"

height="18"

rx="4"

fill="#2563eb"/>

<text

x="765"

y="330"

text-anchor="middle"

font-size="24"

font-weight="700"

fill="#1d4ed8">

RACK C

</text>

</g>

<!-- ==========================================
RACK D
========================================== -->

<g
id="rackD2"
class="warehouse-rack"
data-rack="D"
onclick="abrirRack('D')">

<rect

class="rack"

x="900"

y="170"

width="210"

height="340"

rx="8"/>

<rect

x="930"

y="170"

width="70"

height="18"

rx="4"

fill="#2563eb"/>

<text

x="1005"

y="330"

text-anchor="middle"

font-size="24"

font-weight="700"

fill="#1d4ed8">

RACK D

</text>

</g>

<!-- ==========================================
RACK E
========================================== -->

<g
id="rackE"
class="warehouse-rack"
data-rack="E"
onclick="abrirRack('E')">
<rect

class="rackSmall"

x="1145"

y="185"

width="120"

height="125"

rx="8"/>

<text

x="1205"

y="255"

text-anchor="middle"

font-size="18"

font-weight="700">

RACK E

</text>
</g>

<!-- ==========================================
RACK F
========================================== -->
<g
id="rackF"
class="warehouse-rack"
data-rack="F"
onclick="abrirRack('F')">
<rect

class="rackSmall"

x="1145"

y="330"

width="120"

height="125"

rx="8"/>

<text

x="1205"

y="400"

text-anchor="middle"

font-size="18"

font-weight="700">

RACK F

</text>
</g>
<!-- ======================================================
                 SEPARADOR ENTRE NIVELES
====================================================== -->

<line
x1="40"
y1="585"
x2="1370"
y2="585"
stroke="#202938"
stroke-width="6"/>

<!-- ======================================================
                 NIVEL 1
====================================================== -->

<rect
x="70"
y="625"
width="95"
height="36"
rx="8"
fill="#16a34a"/>

<text
x="118"
y="620"
text-anchor="middle"
font-size="20"
fill="white"
font-weight="700">

NIVEL 1

</text>

<!-- ======================================================
RACK A
====================================================== -->

<g
id="rackA1"
class="warehouse-rack"
data-rack="A"
onclick="abrirRack('A')">

<rect
class="rackGreen"
x="80"
y="660"
width="210"
height="300"
rx="8"/>

<rect
x="110"
y="660"
width="70"
height="18"
rx="4"
fill="#16a34a"/>

<text
x="185"
y="790"
text-anchor="middle"
font-size="24"
font-weight="700"
fill="#15803d">

RACK A

</text>

</g>

<!-- ======================================================
RACK B
====================================================== -->

<g
id="rackB1"
class="warehouse-rack"
data-rack="B"
onclick="abrirRack('B')">

<rect
class="rackGreen"
x="320"
y="630"
width="210"
height="300"
rx="8"/>

<rect
x="350"
y="630"
width="70"
height="18"
rx="4"
fill="#16a34a"/>

<text
x="425"
y="790"
text-anchor="middle"
font-size="24"
font-weight="700"
fill="#15803d">

RACK B

</text>

</g>

<!-- ======================================================
PASILLO
====================================================== -->

<line
x1="565"
y1="630"
x2="565"
y2="930"
stroke="#bfc5ce"
stroke-width="2"
stroke-dasharray="12 12"/>

<line
x1="625"
y1="630"
x2="625"
y2="930"
stroke="#bfc5ce"
stroke-width="2"
stroke-dasharray="12 12"/>

<text
x="595"
y="790"
transform="rotate(90 595 790)"
text-anchor="middle"
font-size="20"
font-weight="700"
fill="#475569">

PASILLO

</text>

<!-- ======================================================
RACK C
====================================================== -->

<g
id="rackC1"
class="warehouse-rack"
data-rack="C"
onclick="abrirRack('C')">

<rect
class="rackGreen"
x="660"
y="630"
width="210"
height="300"
rx="8"/>

<rect
x="690"
y="630"
width="70"
height="18"
rx="4"
fill="#16a34a"/>

<text
x="765"
y="790"
text-anchor="middle"
font-size="24"
font-weight="700"
fill="#15803d">

RACK C

</text>

</g>

<!-- ======================================================
RACK D
====================================================== -->

<g
id="rackD1"
class="warehouse-rack"
data-rack="D"
onclick="abrirRack('D')">

<rect
class="rackGreen"
x="900"
y="630"
width="210"
height="300"
rx="8"/>

<rect
x="930"
y="630"
width="70"
height="18"
rx="4"
fill="#16a34a"/>

<text
x="1005"
y="790"
text-anchor="middle"
font-size="24"
font-weight="700"
fill="#15803d">

RACK D

</text>

</g>

<!-- ======================================================
BAJA ROTACIÓN
====================================================== -->
<g
id="rackG"
class="warehouse-rack"
data-rack="G"
onclick="abrirRack('G')">

<rect
x="1145"
y="630"
width="120"
height="300"
rx="8"
fill="#fff"
stroke="#f59e0b"
stroke-width="3"/>

<text
x="1205"
y="750"
text-anchor="middle"
font-size="22"
font-weight="700"
fill="#ea580c">

RACK G

</text>
</g>
<text
x="1205"
y="790"
text-anchor="middle"
font-size="15"
fill="#555">

Productos

</text>

<text
x="1205"
y="815"
text-anchor="middle"
font-size="15"
fill="#555">

de baja

</text>

<text
x="1205"
y="840"
text-anchor="middle"
font-size="15"
fill="#555">

rotación

</text>

<text
x="1205"
y="850"
text-anchor="middle"
font-size="16"
fill="#555">

Productos

</text>

<text
x="1205"
y="875"
text-anchor="middle"
font-size="16"
fill="#555">

de baja

</text>

<text
x="1205"
y="900"
text-anchor="middle"
font-size="16"
fill="#555">

rotación

</text>

<!-- ======================================================
ENTRADA
====================================================== -->

<line
x1="40"
y1="1035"
x2="560"
y2="1035"
stroke="#444"
stroke-width="2"
stroke-dasharray="12 8"/>

<line
x1="640"
y1="1035"
x2="1370"
y2="1035"
stroke="#444"
stroke-width="2"
stroke-dasharray="12 8"/>

<path
d="M615 960
L585 930
Q595 945 605 960"

fill="none"
stroke="#444"
stroke-width="2"/>

<path
d="M615 960
L615 930
Q605 945 595 960"

fill="none"
stroke="#444"
stroke-width="2"/>

<text
x="600"
y="1070"
text-anchor="middle"
font-size="22"
font-weight="700"
fill="#222">

ENTRADA

</text>

</svg>

</div>