const maleCount = parseInt(document.getElementById('js-input-male').innerText.replace(/,/g, ''));
const femaleCount = parseInt(document.getElementById('js-input-female').innerText.replace(/,/g, ''));
const dataValues = [maleCount, femaleCount];

const total = dataValues.reduce((a, b) => a + b, 0);

const ctx = document.getElementById('js-company-chart').getContext('2d');

// 画面幅によってcutoutの値を設定
var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
var cutoutValue = 45;

if (screenWidth <= 767) {
  cutoutValue = 38;
}

// ドーナツチャートの作成
const myChart2 = new Chart(ctx, {
  type: 'doughnut',
  data: {
    datasets: [{
      label: '採用した労総者に占める女性労働者の割合',
      data: dataValues,
      backgroundColor: ['rgba(51,51,51,1)', 'rgba(197,195,195,1)'],
    }]
  },
  options: {
    cutout: cutoutValue,
    plugins: {
      tooltip: false
    },
  },
});

var fontSize = '24px';
var letterSpacing = '-2px';

if (screenWidth <= 767) {
  fontSize = '17px';
  letterSpacing = '-1px';
}

// 真ん中に表示するオブジェクト
const counter = {
  id: 'counter',
  beforeDraw: function (chart, args, options) {
    const { ctx, chartArea: { top, right, bottom, left, width, height } } = chart;
    const centerX = (left + right) / 2.25;
    const centerY = (top + bottom) / 1.85;

    ctx.save();
    ctx.fillStyle = 'black';
    ctx.font = 'bold ' + fontSize + ' sans-serif';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.letterSpacing = letterSpacing;

    const formattedTotal = total.toLocaleString();
    ctx.fillText(formattedTotal, centerX, centerY);
    ctx.restore();
  }
};

Chart.register(counter);
