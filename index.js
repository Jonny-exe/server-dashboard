import PORT from './env.js'
let CHART_INDEX = 0
const init = async () => {
    setTimeout(updateChart, 1000)
}

const updateChart = async () => {
    const {
        data
    } = await axios.get(`http://localhost:${PORT}/chart.php`)
    const {
        cputemps,
        usage,
        ram_usage
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

    debugger
    const ram = ram_usage / 1024
    cpuChart.data.datasets[0].data.push(temp)
    ramChart.data.datasets[0].data.push(ram)
    cpuChart.data.labels.push(CHART_INDEX++)
    ramChart.data.labels.push(CHART_INDEX++)
    cpuChart.update()
    ramChart.update()

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
            label: 'Cpu temp (ºC)',
            backgroundColor: '#282C34',
            borderColor: '#282C34',
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
            label: 'Usage (%)',
            backgroundColor: '#c678dd',
            borderColor: ' #c678dd',
            data: []
        }]
    },

    // Configuration options go here
    options: {}
});


var ramCtx = document.getElementById('ram-chart').getContext('2d')
var ramChart = new Chart(ramCtx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: [],
        datasets: [{
            label: 'Ram usage (Mb)',
            backgroundColor: '#ABB2BF',
            borderColor: '#ABB2BF',
            data: []
        }]
    },

    // Configuration options go here
    options: {}
});
init()
