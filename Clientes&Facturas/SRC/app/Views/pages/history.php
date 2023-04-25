<div id="loading" style="text-align:center; position:fixed; width:100%; height:100%;top:0; bottom:0; background-color: rgba(255,255,255,0.85); z-index:9999; display:none;">
        <!-- <h1 style="margin-top:25vh; ">Loading...</h1> -->
        <img src="app/Views/templates/loading.gif" alt="Loading..." style="width:300px;margin-top:25vh;"> 
</div>

<style> 
    .a{
        margin-left: 30px;
        text-align:center;
        width: 80%;
        margin-left: 10%;
    }
</style>

<form method="post" action="" name="signup-form">
    <div class="a">
        <div>
            <input type="week" name="week" value="<?echo $week?>" min="2020-W1" max="2024-W1">
            <button onclick=showLoading() type="submit" value="<??>">Enter</button>
        </div>
       
    </div>
</form>

    <style>
    .agrupacion{
        margin-left: 30px;
        display: flex;
        justify-content: space-between;
    }
    .chart-wrap {
        --chart-width:420px;
        --grid-color:#aaa;
        --bar-color:#F16335;
        --bar-thickness:10px;
        --bar-rounded: 3px;
        --bar-spacing:7px;
        font-family:sans-serif;
        width:var(--chart-width);
    }
 
    .chart-wrap .title{
        font-weight:bold;
        padding:1.8em 0;
        text-align:center;
        white-space:nowrap;
    }
 
    /* cuando definimos el gráfico en horizontal, lo giramos 90 grados */
    .chart-wrap.horizontal .grid{
        transform:rotate(-90deg);
    }
 
    .chart-wrap.horizontal .bar::after{
        /* giramos las letras para horizontal*/
        /* transform: rotate(45deg); */
        transform: rotate(5deg);
        padding-top: 0px;
        display: block;
    }
 
    .chart-wrap .grid{
        position:relative;
        padding:5px 0 5px 0;
        width:100%;
        border-left:2px solid var(--grid-color);
        margin-top:100px;
    }
 
    /* posicionamos el % del gráfico*/
    .chart-wrap .grid::before{
        font-size:0.8em;
        font-weight:bold;
        content:'0';
        position:absolute;
        left:-0.5em;
        top:-1.5em;
    }
    .chart-wrap .grid::after{
        font-size:0.8em;
        font-weight:bold;
        content:'100%'; /* maximo de todos los dias*/
        position:absolute;
        right:-1.5em;
        top:-1.5em;
    }
 
    /* giramos las valores de 0% y 100% para horizontal */
    .chart-wrap.horizontal .grid::before, .chart-wrap.horizontal .grid::after {
        transform: rotate(90deg);
    }
 
    .chart-wrap .bar {
        width: var(--bar-value);
        height:var(--bar-thickness);
        margin:var(--bar-spacing) 0;
        background-color:var(--bar-color);
        border-radius:0 var(--bar-rounded) var(--bar-rounded) 0;
    }
 
    .chart-wrap .bar:hover{
        opacity:0.7;
    }
 
    .chart-wrap .bar::after{
        width: 10px;
        content:attr(data-name);
        /* margin-left:100%;  */
        /* padding:10px; */
        display:inline-block;
        white-space:nowrap;
    }

 
    </style>
</head>
<body>
<div class="agrupacion">

    <div class="chart-wrap horizontal">
        <div class="title">Grafico de Ventas Semanal</div>
        <div class="grid" style=" --bar-color:lightblue;">
            <?
            if(isset($semanal)){
                $day=1;
                $total=$semanal['total'];
                while($day<=7){
                    $name_day=date('l', strtotime(date('Y-m-d', strtotime(date('Y')."W".date('W').$day))));
                    $importe=$semanal[$name_day]->importe;
                    if($importe=="") $importe=0;
                    $importe=round($importe,2);
                    $bar_value=$importe * 100 / $total;
                    ?><div class="bar" style="--bar-thickness:38px; --bar-value:<? echo $bar_value."%;"?>" data-name="<?echo $name_day?>" title="<?$importe?>"></div><?
                    $day++;
            }} ?>
        </div>
    </div>   

    <div class="chart-wrap horizontal" >
        <div class="title">Grafico de Ventas Mensual</div>
        <div class="grid" style="margin-top:-5px;  margin-left:50px; --bar-color:#90EED4;">
        <?
            if(isset($mensual)){
                $day=1;
                $total=$mensual['total'];
                while($day<=31){
                    $importe=$mensual[$day]->importe;
                    if($importe=="") $importe=0;
                    $importe=round($importe,2);
                    $bar_value=$importe * 100 / $total;
                    ?><div class="bar" style="--bar-value:<? echo $bar_value."%;"?>" data-name="<?echo $day?>" title="<?$importe?>"></div><?
                    $day++;
            }} ?>
        </div>
    </div>

    

    <div class="chart-wrap horizontal">
        <div class="title">Grafico de Ventas Anual</div>
        <div class="grid" style="--bar-color:#90EE90;">
        <?if(isset($anual)){
            $month=1;
            $total=$anual['total'];
            while($month<=12){
                $importe=$anual[$month]->importe;
                if($importe=="") $importe=0;
                $importe=round($importe,2);
                $bar_value=$importe * 100 / $total;
                $name_month=date('F', strtotime(date('Y-m', strtotime(date('Y')."-".$month))));
                ?><div class="bar" style="--bar-thickness:20px; --bar-value:<?php echo $bar_value."%;"?>" data-name="<?php echo $name_month?>" title="<?php echo $importe?>"></div><?php
                $month++;
            }
        }?>
        </div>
    </div>

</div>
 
</body>
</html>