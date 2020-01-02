const dataPemain = [
    { pemain: 'A', nilai: null, tambahan: [] },
    { pemain: 'B', nilai: null, tambahan: [] },
    { pemain: 'C', nilai: null, tambahan: [] },
    { pemain: 'D', nilai: null, tambahan: [] },
]


function randomNilai(jumlahLempar, pemain) {
    for (let i = 0; i < jumlahLempar; i++) {
        var nilaiDadu = Math.floor(Math.random() * 6) + 1;
        dataPemain[pemain].nilai.push(nilaiDadu)
    }
}

function removeNilai(urutan) {
    for (let i = 0; i < dataPemain[urutan].nilai.length; i++) {
        if (dataPemain[urutan].nilai[i] === 6) {
            dataPemain[urutan].nilai.splice(i, 1)
            i = i - 1
        }
        else if (dataPemain[urutan].nilai[i] === 1) {
            dataPemain[urutan].nilai.splice(i, 1)
            i = i - 1
            if (urutan === 3) {
                dataPemain[0].tambahan.push(1)
            } else {
                dataPemain[urutan + 1].tambahan.push(1)
            }

        }
    }
}

var jumlahLempar = 6
var cekAnggota = true;
var round = 1;
while (cekAnggota) {
    console.log('\n\nRound ' + round + ' \nAfter dice rolled:')
    dataPemain.map((data, i) => {
        if (data.nilai === null) {
            data.nilai = []
        }
        else {
            jumlahLempar = data.nilai.length
        }
        data.nilai = [];
        data.tambahan = [];

        randomNilai(jumlahLempar, i)
        console.log('Player ' + data.pemain + ': ' + data.nilai)

    })
    console.log('\nAfter dice moved/removed:')
    dataPemain.map((data, i) => {
        removeNilai(i)
    })

    dataPemain.map((data, i) => {
        data.nilai = data.nilai.concat(data.tambahan)
        console.log('Player ' + data.pemain + ': ' + data.nilai)
    })

    dataPemain.map((data, i) => {
        if (data.nilai.length === 0) {
            cekAnggota = false
            console.log('\n++++++ \n Player ' + data.pemain + ' won')
        }
    })
    round++
}
