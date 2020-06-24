<!-- jqueryとchart.jsの読み込み -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>

var ctx1 = $('#myChart1');
var ctx2 = $('#myChart2');
var ctx3 = $('#myChart3');
var ctx4 = $('#myChart4');


var options1 = {
    title :{
        display: true,
        position: "top",
        text: "Country of origins",
        fontSize: 18,
        fontColor: "#262626"
    },
    legend : {
        display: true,
        position: "bottom"
    }
};

var options2 = {
    title :{
        display: true,
        position: "top",
        text: "Desired Destinations",
        fontSize: 18,
        fontColor: "#262626"
    },
    legend : {
        display: true,
        position: "bottom"
    }
};

var options3 = {
    title :{
        display: true,
        position: "top",
        text: "Level of Study",
        fontSize: 18,
        fontColor: "#262626"
    },
    legend : {
        display: true,
        position: "bottom"
    }
};

var options4 = {
    title: {
        display: true,
        position: "top",
        text: "Subject areas of interest",
        fontSize: 18,
        fontColor: "#262626"
    },
    scales: {
        xAxes : [{
            ticks: {
                min: 0
            }
        }]
    },
    legend: {
        display: false
    }
};

// datasetsの中で、先ほど読み出してきた$txtの配列のそれぞれの値をセットしている。例えば$txt[0]はUK、$txt[1]はUSA。
var data1 = {
    
    datasets: [{
        data: <?= json_encode($json2); ?>,
        backgroundColor: [
            "#6A2B86",
            "#F0E52F",
            "#1ABEBE",
            "#ED871D",
            "#DF3291",
            "#66266C",
        ],
        // borderColor: [
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626"
        // ],
        // borderWidth: [1, 1, 1, 1, 1, 1]
        borderAlign: "inner"
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: <?= json_encode($json); ?>
    
    };

    var data2 = {
    
    datasets: [{
        data: <?= json_encode($json4); ?>,
        backgroundColor: [
            "#71C3FE",
            "#D0FA96",
            "#F687AF"
        ],
        // borderColor: [
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626"
        // ],
        // borderWidth: [1, 1, 1, 1, 1, 1]
        borderAlign: "inner"
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels:  <?= json_encode($json3); ?>};

    var data3 = {
    
    datasets: [{
        data: <?= json_encode($json6); ?>,
        backgroundColor: [
            "#71C3FE",
            "#D0FA96",
            "#F687AF"
        ],
        // borderColor: [
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626",
        //     "#262626"
        // ],
        // borderWidth: [1, 1, 1, 1, 1, 1]
        borderAlign: "inner"
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels:  <?= json_encode($json5); ?>
    };

var data4 = {
    datasets: [{
        // barPercentage: 0.5,
        // barThickness: "flex",
        // maxBarThickness: 8,
        // minBarLength: 2,
        backgroundColor: "#25DD76",
        borderColor: "#25DD76",
        borderWidth: 1,
        data: <?= json_encode($json8); ?>
    }],
    labels: <?= json_encode($json7); ?>
    
};


var myPieChart1 = new Chart(ctx1, {
    type: 'pie',
    data: data1,
    options: options1
});

var myPieChart2 = new Chart(ctx2, {
    type: 'pie',
    data: data2,
    options: options2
});

var myPieChart3 = new Chart(ctx3, {
    type: 'pie',
    data: data3,
    options: options3
});

var myBarChart4 = new Chart(ctx4, {
    type: 'horizontalBar',
    data: data4,
    options: options4
});


</script>