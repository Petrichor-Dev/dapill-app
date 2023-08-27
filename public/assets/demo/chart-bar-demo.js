// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    //nama leader
    labels: ["January", "February", "March", "April", "May", "June", "Januadary", "Fedabruary", "Masdarch", "Apasdril", "Mdaay", "Jdaune","Jdaanuary", "Fedabruary", "Ma23rch", "Aprril", "Mwaey", "Junfe",],
    datasets: [{
      label: "Revenue",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      //data jumlah suara
      data: [4215, 5312, 6251, 7841, 9821, 1231,4215, 5312, 6251, 7841, 9821, 1231,4215, 5312, 6251, 7841, 9821, 1231,],
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
          max: 20000,
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
