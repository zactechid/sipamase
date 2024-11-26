<?php

namespace App\Http\Controllers;

use App\Models\tahun;
use App\Models\agenda;
use App\Models\uploadfoto;
use App\Models\pemrakarsa;
use App\Models\harmonisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class dataController extends Controller
{
    public function index()
    {
        $pemrakarsa = pemrakarsa::all();
        $tahun = tahun::all();
        $Pengajuan = '';
        $Administrasi = '';
        $Rapat = '';
        $Penyampaian = '';
        $pemrakarsaGet = '';
        $tahunGet = '';
        
           $selesai_harmonisasi = '';
       $pengembalian_disempurnakan = '';

        $pengembalian_dilanjutkan = '';

        return view('grafik.grafik', [
            'title' => 'Grafik Harmonisasi'
        ], compact('Pengajuan', 'Administrasi', 'Rapat', 'Penyampaian', 'pemrakarsa', 'pemrakarsaGet', 'tahun', 'tahunGet', 'selesai_harmonisasi', 'pengembalian_disempurnakan', 'pengembalian_dilanjutkan'));
    }

    public function grafikAdmin(Request $request)
    {
        $pemrakarsaGet = $request->input('grafikPemrakarsa');
        $tahunGet = $request->input('grafikTahun');
        $pemrakarsa = pemrakarsa::all();
        $get = pemrakarsa::where('nama', $pemrakarsaGet)->first('id');
        $tahun = tahun::all();
        $tahunId = tahun::where('no', $tahunGet)->first('id');

        $Pengajuan = harmonisasi::where('padministrasi_id', 1)->where('pemrakarsa_id', $get->id)->where('tahun_id', $tahunId->id)->count();
        $Administrasi = harmonisasi::where('padministrasi_id', 2)->where('pemrakarsa_id', $get->id)->where('tahun_id', $tahunId->id)->count();
        $Rapat = harmonisasi::where('padministrasi_id', 3)->where('pemrakarsa_id', $get->id)->where('tahun_id', $tahunId->id)->count();
        $Penyampaian = harmonisasi::where('pemrakarsa_id', $get->id)->whereIn('padministrasi_id', [4, 5])->where('tahun_id', $tahunId->id)->count();
           $selesai_harmonisasi = harmonisasi::where('pemrakarsa_id', $get->id)
            ->where('tahun_id', $tahunId->id)
            ->whereRaw("LOWER(REPLACE(status_penyampaian, ' ', '')) = 'selesaiharmonisasi'")
            ->count();
       $pengembalian_disempurnakan = harmonisasi::where('pemrakarsa_id', $get->id)
            ->where('tahun_id', $tahunId->id)
            ->whereRaw("LOWER(REPLACE(status_penyampaian, ' ', '')) = 'pengembalianuntukdisempurnakan'")
            ->count();

        $pengembalian_dilanjutkan = harmonisasi::where('pemrakarsa_id', $get->id)
            ->where('tahun_id', $tahunId->id)
            ->whereRaw("LOWER(REPLACE(status_penyampaian, ' ', '')) = 'pengembalianuntuktidakdilanjutkan'")
            ->count();

        return view('grafik.grafik', [
            'title' => 'Grafik Harmonisasi'
        ], compact('Pengajuan', 'Administrasi', 'Rapat', 'Penyampaian', 'pemrakarsa', 'pemrakarsaGet', 'tahun', 'tahunGet', 'selesai_harmonisasi', 'pengembalian_disempurnakan', 'pengembalian_dilanjutkan'));

    }

    public function grafik(Request $request)
    {
        $pemrakarsa = $request->input('grafik');
        $tahunGet = $request->input('grafikTahun');
        $get = pemrakarsa::where('nama', $pemrakarsa)->first('id');
        $tahun = tahun::where('no', $tahunGet)->first('id');

        $Pengajuan = harmonisasi::where('padministrasi_id', 1)->where('pemrakarsa_id', $get->id)->where('tahun_id', $tahun->id)->count();
        $Administrasi = harmonisasi::where('padministrasi_id', 2)->where('pemrakarsa_id', $get->id)->where('tahun_id', $tahun->id)->count();
        $Rapat = harmonisasi::where('padministrasi_id', 3)->where('tahun_id', $tahun->id)->where('pemrakarsa_id', $get->id)->where('tahun_id', $tahun->id)->count();
        $Penyampaian = harmonisasi::where('pemrakarsa_id', $get->id)->whereIn('padministrasi_id', [4, 5])->where('tahun_id', $tahun->id)->count();

        $data = harmonisasi::where('pemrakarsa_id', $get->id)->where('tahun_id', $tahun->id)->get();
        
        $selesai_harmonisasi = harmonisasi::where('pemrakarsa_id', $get->id)
            ->where('tahun_id', $tahun->id)
            ->whereRaw("LOWER(REPLACE(status_penyampaian, ' ', '')) = 'selesaiharmonisasi'")
            ->count();
       $pengembalian_disempurnakan = harmonisasi::where('pemrakarsa_id', $get->id)
            ->where('tahun_id', $tahun->id)
            ->whereRaw("LOWER(REPLACE(status_penyampaian, ' ', '')) = 'pengembalianuntukdisempurnakan'")
            ->count();

        $pengembalian_dilanjutkan = harmonisasi::where('pemrakarsa_id', $get->id)
            ->where('tahun_id', $tahun->id)
            ->whereRaw("LOWER(REPLACE(status_penyampaian, ' ', '')) = 'pengembalianuntuktidakdilanjutkan'")
            ->count();

        return view('grafik.grafikPublic', [
            'title' => 'Grafik Harmonisasi'
        ], compact('Pengajuan', 'Administrasi', 'Rapat', 'Penyampaian', 'pemrakarsa', 'data', 'selesai_harmonisasi', 'pengembalian_disempurnakan', 'pengembalian_dilanjutkan'));
    }

    public function agenda()
    {
        $agenda = agenda::with('pemrakarsa')->get();
        $pemrakarsa = pemrakarsa::all();
        return view('agenda.agenda', [
            'title' => 'Agenda Rapat'
        ], compact('agenda', 'pemrakarsa'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'pemrakarsa' => 'required|exists:pemrakarsa,nama',
            'harmonisasi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required|max:150'
        ]);

        $data = $request->input();
        $pemrakarsa_id = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');
        agenda::create([
            'nama' => $data['nama'],
            'pemrakarsa_id' => $pemrakarsa_id->id,
            'harmonisasi' => $data['harmonisasi'],
            'tanggal' => $data['tanggal'],
            'lokasi' => $data['lokasi'],
        ]);

        return redirect()->to('/agenda')->with('success', 'Berhasil Menambahkan Data');
    }

    public function update(agenda $agenda, Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'pemrakarsa' => 'required|exists:pemrakarsa,nama',
            'harmonisasi' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required|max:100',
            'foto' => 'nullable|file|mimes:jpeg,jpg,png|max:5000',
            ''
        ]);
        $data = $request->input();
        $dataFile = $request->file('foto');

        $pemrakarsa_id = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');
        if ($request->file('foto')) {
            if ($request->input('oldImage')) {
                Storage::delete($request->input('oldImage'));
            }
            $foto = $request->file('foto')->store('image');
            $img = $foto;
        } else {
            $img = $request->input('oldImage');
        }
        // ($dataFile['foto']) ? $foto = $dataFile['foto']->store('images') : $foto = '';

        agenda::where('nama', $agenda->nama)
            ->update([
                'nama' => $data['nama'],
                'pemrakarsa_id' => $pemrakarsa_id->id,
                'harmonisasi' => $data['harmonisasi'],
                'tanggal' => $data['tanggal'],
                'lokasi' => $data['lokasi'],

            ]);

        return redirect()->to('/agenda')->with('success', 'Berhasil Menambahkan Data');
    }

    public function hapus(agenda $agenda)
    {
        ($agenda->foto) ? Storage::delete($agenda->foto) : '';
        agenda::where('nama', $agenda->nama)->delete();
        return redirect()->to('/agenda')->with('success', 'Berhasil Hapus Data');
    }

    public function destroy(agenda $agenda)
    {
        Storage::delete($agenda->foto);
        agenda::where('nama', $agenda->nama)->update([
            'foto' => null
        ]);
        return redirect()->to('/agenda')->with('success', 'Berhasil Hapus Foto');
    }

    public function aktif($id)
    {
        agenda::where('id', $id)->update([
            'aktif' => true
        ]);

        return redirect()->to('/agenda')->with('success', 'Berhasil aktifkan agenda');
    }

    public function nonaktif($id)
    {
        agenda::where('id', $id)->update([
            'aktif' => false
        ]);

        return redirect()->to('/agenda')->with('success', 'Berhasil nonaktifkan agenda');
    }
    
    public function uploadfoto()
    {
        $foto = uploadfoto::all();
        return view('upload.upload', [
            'title' => 'Foto Kegiatan'
        ], compact('foto'));
    }
    
    public function uploadfoto_post(Request $request, $id = null) {
        $rule =  [
            'judul_foto' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required|max:100'
        ];
        if (empty($id)) {
            $rule['foto'] =  'required|image|mimes:jpeg,jpg,png|max:5000';
        }
        $validator = validator()->make($request->all(), $rule);
        if ($validator->fails()) {
            return redirect()->to('/uploadfoto')->with('error', $validator->errors())->withInput();
        }
        $data = $request->input();
        
        if (!empty($id)) {
            $dat = uploadfoto::find($id);
            if (!$dat) {
                return redirect()->to('/uploadfoto')->with('error', 'Data foto tidak ditemukan');
            }
                $dat->judul_foto = $data['judul_foto'];
                $dat->tanggal = $data['tanggal'];
                $dat->lokasi = $data['lokasi'];
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto')->store('image');
                $img = $foto;
                if (!empty($dat->foto)) {
                    Storage::delete($dat->foto);
                }
                $dat->foto = $img;
            }
            $dat->save();
            return redirect()->to('/uploadfoto')->with('success', 'Berhasil menyimpan Data');
        }else{
            if ($request->file('foto')) {
                $foto = $request->file('foto')->store('image');
                $img = $foto;
                $m = new uploadfoto;
                $m->judul_foto = $data['judul_foto'];
                $m->tanggal = $data['tanggal'];
                $m->lokasi = $data['lokasi'];
                $m->foto = $img;
                $m->save();
                 return redirect()->to('/uploadfoto')->with('success', 'Berhasil Menambahkan Data');
            }else{
                return redirect()->to('/uploadfoto')->with('error', 'Silahkan tentukan Foto')->withInput();
            }
        }
    }
    
    public function remove_foto($id) { 
        $m =uploadfoto::find($id);
        if (!$m) {
            return redirect()->to('/uploadfoto')->with('error', 'Silahkan tentukan Foto yang ingin dihapus');
        }
        Storage::delete($m->foto);
        $m->delete();
        return redirect()->to('/uploadfoto')->with('success', 'Berhasil Hapus Foto');
    }
}
