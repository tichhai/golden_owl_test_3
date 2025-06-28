<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G-Scores | Tra cứu điểm thi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Rubik', sans-serif; }
        .container { max-width: 900px; margin-top: 40px; }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4">G-Scores - Tra cứu điểm thi THPT 2024</h1>
    <div class="card mb-4">
        <div class="card-body">
            <form id="searchForm" class="row g-3">
                <div class="col-auto">
                    <input type="text" class="form-control" id="sbd" placeholder="Nhập số báo danh" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Tra cứu</button>
                </div>
            </form>
            <div id="searchResult" class="mt-3"></div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Thống kê theo môn</div>
                <div class="card-body">
                    <canvas id="subjectChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Báo cáo phân loại học sinh</div>
                <div class="card-body">
                    <ul id="reportList"></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Top 10 học sinh khối A (Toán, Lý, Hóa)</div>
        <div class="card-body">
            <table class="table table-bordered" id="topATable">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>SBD</th>
                    <th>Toán</th>
                    <th>Vật lý</th>
                    <th>Hóa học</th>
                    <th>Tổng khối A</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<script>
// Tra cứu điểm
const searchForm = document.getElementById('searchForm');
const searchResult = document.getElementById('searchResult');
searchForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    const sbd = document.getElementById('sbd').value.trim();
    searchResult.innerHTML = 'Đang tra cứu...';
    const res = await fetch(`/api/search?sbd=${sbd}`);
    const data = await res.json();
    if (data.error) {
        searchResult.innerHTML = `<div class='alert alert-danger'>${data.error}</div>`;
    } else {
        let html = `<table class='table'><tr><th>Môn</th><th>Điểm</th></tr>`;
        for (const [k, v] of Object.entries(data)) {
            if (["sbd","created_at","updated_at","id","ma_ngoai_ngu"].includes(k)) continue;
            html += `<tr><td>${k.replace('_',' ').toUpperCase()}</td><td>${v ?? '-'}</td></tr>`;
        }
        html += `</table>`;
        searchResult.innerHTML = html;
    }
});

// Thống kê theo môn
async function loadSubjectStats() {
    const res = await fetch('/api/subject-stats');
    const stats = await res.json();
    const labels = Object.keys(stats['toan']);
    const datasets = Object.keys(stats).map((subject, idx) => ({
        label: subject.replace('_',' ').toUpperCase(),
        data: labels.map(l => stats[subject][l]),
        backgroundColor: `rgba(${50+idx*20},${100+idx*10},${200-idx*15},0.5)`
    }));
    new Chart(document.getElementById('subjectChart'), {
        type: 'bar',
        data: { labels, datasets },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
}
loadSubjectStats();

// Báo cáo phân loại học sinh
async function loadReport() {
    const res = await fetch('/api/report');
    const report = await res.json();
    const list = document.getElementById('reportList');
    list.innerHTML = '';
    for (const [k, v] of Object.entries(report)) {
        list.innerHTML += `<li>${k}: <b>${v}</b> học sinh</li>`;
    }
}
loadReport();

// Top 10 khối A
async function loadTopA() {
    const res = await fetch('/api/top-a');
    const data = await res.json();
    const tbody = document.querySelector('#topATable tbody');
    tbody.innerHTML = '';
    data.forEach((s, i) => {
        tbody.innerHTML += `<tr><td>${i+1}</td><td>${s.sbd}</td><td>${s.toan}</td><td>${s.vat_li}</td><td>${s.hoa_hoc}</td><td>${s.total_a}</td></tr>`;
    });
}
loadTopA();
</script>
</body>
</html>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
