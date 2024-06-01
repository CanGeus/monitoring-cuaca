// Variabel untuk menyimpan instance Chart untuk setiap grafik
let myLineChart1, myLineChart2, myLineChart3, myLineChart4;

// Function untuk render chart
function renderChart(ctx, labels, data, label) {
  return new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: label,
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: data,
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 10
          }
        }],
        yAxes: [{
          ticks: {
            maxTicksLimit: 10,
            padding: 10,
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
      }
    }
  });
}

// Function untuk render chart suhu udara
function renderSuhuUdara(ctx, labels, data) {
  if (myLineChart1) {
    myLineChart1.data.labels = labels;
    myLineChart1.data.datasets[0].data = data;
    myLineChart1.update();
  } else {
    myLineChart1 = renderChart(ctx, labels, data, "Suhu");
  }
}

// Function untuk render chart kelembapan udara
function renderKelembapanUdara(ctx, labels, data) {
  if (myLineChart2) {
    myLineChart2.data.labels = labels;
    myLineChart2.data.datasets[0].data = data;
    myLineChart2.update();
  } else {
    myLineChart2 = renderChart(ctx, labels, data, "Kelembapan");
  }
}

// Function untuk render chart intensitas cahaya
function renderIntensitasCahaya(ctx, labels, data) {
  if (myLineChart3) {
    myLineChart3.data.labels = labels;
    myLineChart3.data.datasets[0].data = data;
    myLineChart3.update();
  } else {
    myLineChart3 = renderChart(ctx, labels, data, "Intensitas");
  }
}

// Function untuk render chart kelembapan tanah
function renderKelembapanTanah(ctx, labels, data) {
  if (myLineChart4) {
    myLineChart4.data.labels = labels;
    myLineChart4.data.datasets[0].data = data;
    myLineChart4.update();
  } else {
    myLineChart4 = renderChart(ctx, labels, data, "Kelembapan");
  }
}

// Function untuk fetch data dan render chart
async function fetchDataAndRenderChart() {
  const apiUrl = './api/get_data.php';

  try {
    const response = await fetch(apiUrl);
    const data = await response.json();

    const timestamps = data.map(entry => entry.waktu);
    const temperatures = data.map(entry => entry.suhu_udara);
    const humidity = data.map(entry => entry.kelembapan_udara);
    const cahaya = data.map(entry => entry.intensitas_cahaya);
    const soil = data.map(entry => entry.kelembapan_tanah);

    renderSuhuUdara(document.getElementById("myAreaChart"), timestamps, temperatures);
    renderKelembapanUdara(document.getElementById("myAreaChart1"), timestamps, humidity);
    renderIntensitasCahaya(document.getElementById("myAreaChart2"), timestamps, cahaya);
    renderKelembapanTanah(document.getElementById("myAreaChart3"), timestamps, soil);

  } catch (error) {
    console.error('Error fetching or parsing data:', error);
  }
}

// Panggil fetchDataAndRenderChart untuk memulai
fetchDataAndRenderChart();
// Refresh setiap 5 detik
setInterval(fetchDataAndRenderChart, 5000);
