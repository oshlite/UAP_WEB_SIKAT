id = "charts-initialization" >
    document.addEventListener('DOMContentLoaded', function () {
        // Visitor Chart
        const visitorChart = echarts.init(document.getElementById('visitor-chart'));
        const visitorOption = {
            animation: false,
            color: ['rgba(87, 181, 231, 1)'],
            tooltip: {
                trigger: 'axis',
                backgroundColor: 'rgba(255, 255, 255, 0.8)',
                borderColor: '#e2e8f0',
                borderWidth: 1,
                textStyle: {
                    color: '#1f2937'
                }
            },
            grid: {
                top: 10,
                right: 10,
                bottom: 30,
                left: 40
            },
            xAxis: {
                type: 'category',
                data: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'],
                axisLine: {
                    lineStyle: {
                        color: '#e2e8f0'
                    }
                },
                axisLabel: {
                    color: '#1f2937'
                }
            },
            yAxis: {
                type: 'value',
                axisLine: {
                    show: false
                },
                axisTick: {
                    show: false
                },
                splitLine: {
                    lineStyle: {
                        color: '#e2e8f0'
                    }
                },
                axisLabel: {
                    color: '#1f2937'
                }
            },
            series: [{
                name: 'Jumlah Tamu',
                type: 'line',
                smooth: true,
                symbol: 'none',
                lineStyle: {
                    width: 3
                },
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                        offset: 0,
                        color: 'rgba(87, 181, 231, 0.3)'
                    },
                    {
                        offset: 1,
                        color: 'rgba(87, 181, 231, 0.05)'
                    }
                    ])
                },
                data: [12, 25, 45, 32, 28, 35, 42, 38, 25, 18, 30, 20]
            }]
        };
        visitorChart.setOption(visitorOption);

        // Area Distribution Chart
        const areaChart = echarts.init(document.getElementById('area-chart'));
        const areaOption = {
            animation: false,
            color: [
                'rgba(87, 181, 231, 1)',
                'rgba(141, 211, 199, 1)',
                'rgba(251, 191, 114, 1)',
                'rgba(252, 141, 98, 1)',
                'rgba(190, 186, 218, 1)'
            ],
            tooltip: {
                trigger: 'item',
                backgroundColor: 'rgba(255, 255, 255, 0.8)',
                borderColor: '#e2e8f0',
                borderWidth: 1,
                textStyle: {
                    color: '#1f2937'
                }
            },
            series: [{
                name: 'Distribusi Area',
                type: 'pie',
                radius: ['40%', '70%'],
                center: ['50%', '50%'],
                avoidLabelOverlap: false,
                itemStyle: {
                    borderRadius: 8,
                    borderColor: '#fff',
                    borderWidth: 2
                },
                label: {
                    show: false
                },
                emphasis: {
                    label: {
                        show: true,
                        formatter: '{b}: {c} ({d}%)',
                        fontSize: 12,
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: [{
                    value: 35,
                    name: 'Meja Keluarga Wanita'
                },
                {
                    value: 30,
                    name: 'Meja Keluarga Pria'
                },
                {
                    value: 20,
                    name: 'Meja VIP'
                },
                {
                    value: 50,
                    name: 'Meja Tamu Luar Provinsi'
                },
                {
                    value: 10,
                    name: 'Meja Komunitas'
                }
                ]
            }]
        };
        areaChart.setOption(areaOption);
        // Handle window resize
        window.addEventListener('resize', function () {
            visitorChart.resize();
            areaChart.resize();
        });
    });


id = "mobile-menu-toggle" 
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuButton = document.querySelector('button[aria-label="mobile-menu"]');
        if (mobileMenuButton) {
            const sidebar = document.querySelector('.md\\:flex-shrink-0');
            mobileMenuButton.addEventListener('click', function () {
                if (sidebar.classList.contains('hidden')) {
                    sidebar.classList.remove('hidden');
                } else {
                    sidebar.classList.add('hidden');
                }
            });
        }
    });

id = "form-controls"
document.addEventListener('DOMContentLoaded', function () {
    // Custom checkbox functionality
    const customCheckboxes = document.querySelectorAll('.custom-checkbox');
    customCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function () {
            this.checked = !this.checked;
        });
    });

    // Custom radio functionality
    const customRadios = document.querySelectorAll('.custom-radio');
    customRadios.forEach(radio => {
        radio.addEventListener('click', function () {
            const name = this.getAttribute('name');
            if (name) {
                document.querySelectorAll(`.custom-radio[name="${name}"]`).forEach(r => {
                    r.checked = false;
                });
                this.checked = true;
            }
        });
    });

    // Custom switch functionality
    const customSwitches = document.querySelectorAll('.custom-switch input');
    customSwitches.forEach(switchInput => {
        switchInput.addEventListener('change', function () {
            // Additional functionality can be added here
        });
    });
});

// Get current date and time
var now = new Date();
var tanggal = now.toLocaleDateString('id-ID', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
});


// Insert date and time into HTML
document.getElementById("datetime").innerHTML = tanggal;
