import csv

input_file = 'database/data/diem_thi_thpt_2024.csv'
output_file = 'database/data/diem_thi_thpt_2024_unique.csv'

seen = set()
rows = []

with open(input_file, newline='', encoding='utf-8') as infile:
    reader = csv.DictReader(infile)
    header = reader.fieldnames
    for row in reader:
        sbd = row['sbd']
        if sbd not in seen:
            seen.add(sbd)
            rows.append(row)

with open(output_file, 'w', newline='', encoding='utf-8') as outfile:
    writer = csv.DictWriter(outfile, fieldnames=header)
    writer.writeheader()
    writer.writerows(rows)

print(f'Done! Đã xuất file không trùng SBD: {output_file}')
