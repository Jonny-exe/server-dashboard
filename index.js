import URL from './env.js'
let CHART_INDEX = 0
const init = async () => {
    setInterval(updateChart, 1000)
}

const updateChart = async () => {
    const {
        data
    } = await axios.get(`${URL}/chart.php`)
    const {
        cputemps,
        usage,
        ram_usage
    } = data

    if (typeof(cputemps) != "string") {
        let temp = 0
        cputemps.forEach((x) => {
            temp += x / cputemps.length / 1000
        })
        temp = Math.round(temp)
        cpuChart.data.datasets[0].data.push(temp)
        cpuChart.data.labels.push(CHART_INDEX++)
        cpuChart.update()
    }

    const ram = ram_usage / 1024
    ramChart.data.datasets[0].data.push(ram)
    ramChart.data.labels.push(CHART_INDEX++)
    ramChart.update()

    usageChart.reset()
    usageChart.data.labels = []
    usageChart.data.datasets[0].data = []
    for (let i = 0; i < usage.length; i++) {
        usageChart.data.labels.push(usage[i].task_name)
        usageChart.data.datasets[0].data.push(usage[i].task_usage)
    }
    usageChart.update()
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
