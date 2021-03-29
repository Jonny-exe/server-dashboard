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
        cputemps
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
    console.log(temp)
    chart.data.datasets[0].data.push(temp)
    chart.data.labels.push(CHART_INDEX++)
    chart.update()
    setTimeout(updateChart, 1000)
}

var ctx = document.getElementById('chart').getContext('2d')
var chart = new Chart(ctx, {
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

init()