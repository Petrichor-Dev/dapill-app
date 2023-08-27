// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var app = "{{ $totalDpt }}"
console.log(app)
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    //nama leader
    labels: ["Agus", "Bambang", "Salim", "Arman", "Yuni"],
    datasets: [{
      label: "Total Pemilih",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      //data jumlah suara
      data: [12, 31, 45, 83, 75].sort((a,b) => a-b),
      // sort((a,b) => a-b)
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          //max total data yang di tampilkan
          maxTicksLimit: 19
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 150,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
