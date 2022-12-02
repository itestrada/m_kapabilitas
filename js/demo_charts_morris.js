var morrisCharts = function() {
/*
    Morris.Line({
      element: 'morris-line-example',
      data: [
        { y: '2006', a: 100, b: 90 },
        { y: '2007', a: 75,  b: 65 },
        { y: '2008', a: 50,  b: 40 },
        { y: '2009', a: 75,  b: 65 },
        { y: '2010', a: 50,  b: 40 },
        { y: '2011', a: 75,  b: 65 },
        { y: '2012', a: 100, b: 90 }
      ],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Series A', 'Series B'],
      resize: true,
      lineColors: ['#33414E', '#95B75D']
    });


    Morris.Area({
        element: 'morris-area-example',
        data: [
            { y: '2006', a: 100, b: 90 },
            { y: '2007', a: 75,  b: 65 },
            { y: '2008', a: 50,  b: 40 },
            { y: '2009', a: 75,  b: 65 },
            { y: '2010', a: 50,  b: 40 },
            { y: '2011', a: 75,  b: 65 },
            { y: '2012', a: 100, b: 90 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        resize: true,
        lineColors: ['#1caf9a', '#FEA223']
    });
*/

    Morris.Bar({
        element: 'morris-bar-example',
        data: [
            { y: 'sales A', a: 100, b: 90 },
            { y: 'sales B', d: 75,  c: 65 },
            { y: 'sales C', a: 50,  b: 40 },
            { y: 'sales D', a: 75,  d: 65 },
            { y: 'sales E', a: 50,  b: 40 },
            { y: 'sales F', a: 75,  c: 65 },
            { y: 'sales G', d: 100, b: 90 }
        ],
        xkey: 'y',
        ykeys: ['a', 'b', 'c', 'd'],
        labels: ['S', 'O', 'L', 'H'],
        barColors: ['#B64645', '#33414E', '#654322', '#983373'],
		xLabelAngle: 30
    });


    Morris.Donut({
        element: 'morris-donut-example',
        data: [
            {label: "S", value: 12},
            {label: "O", value: 30},
            {label: "H", value: 20}
        ],
        colors: ['#95B75D', '#1caf9a', '#FEA223']
    });

}();