let CHART_INDEX = 0
console.log("HELLO")
const init = async () => {
    setTimeout(updateChart, 1000)
}

const updateChart = async () => {
    const {
        data
    } = await axios.get('http://localhost:3000/chart.php')
    const {
        cputemps,
        usage
    } = data
    if (typeof(cputemps) == "string") {
        return
    }
    debugger
    let temp = 0
    cputemps.forEach((x) => {
        temp += x / cputemps.length / 1000
    })
    temp = Math.round(temp)

    cpuChart.data.datasets[0].data.push(temp)
    cpuChart.data.labels.push(CHART_INDEX++)
    cpuChart.update()

    usageChart.reset()
    usageChart.data.labels = []
    usageChart.data.datasets[0].data = []
    for (let i = 0; i < usage.length; i++) {
        usageChart.data.labels.push(usage[i].task_name)
        usageChart.data.datasets[0].data.push(usage[i].task_usage)
    }
    usageChart.update()

    setTimeout(updateChart, 1000)
}

var cpuCtx = document.getElementById('cpu-chart').getContext('2d')
var cpuChart = new Chart(cpuCtx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: [],
        datasets: [{
            label: 'Cpu temp',
            backgroundColor: '#26c6da',
            borderColor: '#26c6da',
            data: []
        }]
    },

    // Configuration options go here
    options: {}
});

var usageCtx = document.getElementById('usage-chart').getContext('2d')
var usageChart = new Chart(usageCtx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: [],
        datasets: [{
            label: 'Usage',
            backgroundColor: 'purple',
            borderColor: 'purple',
            data: []
        }]
    },

    // Configuration options go here
    options: {}
});
init()