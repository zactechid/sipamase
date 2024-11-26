<?php

namespace App\Http\Controllers;

use App\Models\doc_administrasi;
use App\Models\tahun;
use App\Models\rancangan;
use App\Models\pemrakarsa;
use App\Models\harmonisasi;
use Illuminate\Http\Request;
use App\Models\padministrasi;
use App\Models\doc_penyampaian;
use App\Models\doc_rapat;
use App\Models\pdraf;
use Illuminate\Support\Facades\Storage;

class penyampaianController extends Controller
{
    public function index()
    {
        $post_tahun = '';
        $post_harmonisasi = '';
        $post_pemrakarsa = '';
        $rancangan = rancangan::all();
        $tahun = tahun::all();
        $pemrakarsa = pemrakarsa::all();
        $harmonisasi = harmonisasi::where('padministrasi_id', 4)->orWhere('padministrasi_id', 5)->get();
        return view('penyampaian.penyampaian', [
            'title' => 'Penyampaian Harmonisasi'
        ], compact('harmonisasi', 'post_tahun', 'post_harmonisasi', 'post_pemrakarsa', 'rancangan', 'tahun', 'pemrakarsa'));
    }

    public function index_filter(Request $request)
    {
        $rancangan = rancangan::all();
        $tahun = tahun::all();
        $pemrakarsa = pemrakarsa::all();
        $data = $request->input();
        $post_tahun = $request->input('tahun');
        $post_harmonisasi = $request->input('harmonisasi');
        $post_pemrakarsa = $request->input('pemrakarsa');
        $checkUser = auth()->user()->pemrakarsa_id;

        // filter tiga
        if ($data['tahun'] && $data['harmonisasi'] && $data['pemrakarsa']) {
            $filter_tahun = tahun::where('no', $data['tahun'])->first('id');
            $filter_rancangan = rancangan::where('nama', $data['harmonisasi'])->first('id');
            $filter_pemrakarsa = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');
            $harmonisasi = harmonisasi::where('rancangan_id', $filter_rancangan->id)->where('tahun_id', $filter_tahun->id)->where('pemrakarsa_id', $filter_pemrakarsa->id)->where(function($query) {
                $query->where('padministrasi_id', 4)->orWhere('padministrasi_id', 5);
                
            })->get();
        }
        // filter dua
        elseif ($data['tahun'] && $data['harmonisasi']) {
            $filter_tahun = tahun::where('no', $data['tahun'])->first('id');
            $filter_rancangan = rancangan::where('nama', $data['harmonisasi'])->first('id');

            $harmonisasi = harmonisasi::where('rancangan_id', $filter_rancangan->id)->where('tahun_id', $filter_tahun->id)->where(function($query) {
                $query->where('padministrasi_id', 4)->orWhere('padministrasi_id', 5);
                
            })->get();
        }
        elseif ($data['tahun'] && $data['pemrakarsa']) {
            $filter_tahun = tahun::where('no', $data['tahun'])->first('id');
            $filter_pemrakarsa = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');

            $harmonisasi = harmonisasi::where('pemrakarsa_id', $filter_pemrakarsa->id)->where('tahun_id', $filter_tahun->id)->where(function($query) {
                $query->where('padministrasi_id', 4)->orWhere('padministrasi_id', 5);
                
            })->get();
        }
        elseif ($data['harmonisasi'] && $data['pemrakarsa']) {
            $filter_rancangan = rancangan::where('nama', $data['harmonisasi'])->first('id');
            $filter_pemrakarsa = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');

            $harmonisasi = harmonisasi::where('pemrakarsa_id', $filter_pemrakarsa->id)->where('rancangan_id', $filter_rancangan->id)->where(function($query) {
                $query->where('padministrasi_id', 4)->orWhere('padministrasi_id', 5);
                
            })->get();
        }
        // Filter satu
        elseif ($data['tahun']) {
            $filter_tahun = tahun::where('no', $data['tahun'])->first('id');
                $harmonisasi = harmonisasi::where('tahun_id', $filter_tahun->id)->where(function($query) {
                $query->where('padministrasi_id', 4)->orWhere('padministrasi_id', 5);
                
            })->get();
        } 
        elseif ($data['harmonisasi']) {
            $filter_rancangan = rancangan::where('nama', $data['harmonisasi'])->first('id');

            $harmonisasi = harmonisasi::where('rancangan_id', $filter_rancangan->id)->get();
        } 
        elseif ($data['pemrakarsa']) {
            $filter_pemrakarsa = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');
            
            $harmonisasi = harmonisasi::where('pemrakarsa_id', $filter_pemrakarsa->id)->get();
        }

        return view('penyampaian.penyampaian', [
            'title' => 'Penyampaian Harmonisasi'
        ], compact('rancangan', 'harmonisasi', 'tahun', 'pemrakarsa', 'post_tahun', 'post_harmonisasi', 'post_pemrakarsa', 'rancangan', 'tahun', 'pemrakarsa'));
    }

    public function show(harmonisasi $harmonisasi)
    {
        $getHarmonisasi = $harmonisasi;
        $rancangan = $harmonisasi->rancangan->nama;
        
        $pdraf = pdraf::all();
        $statusPenyampaian = ['Selesai Harmonisasi', 'Di Tolak', 'Dikembalikan'];
        $status = ['Selesai Harmonisasi', 'Pengembalian Untuk Disempurnakan', 'Pengembalian Untuk Tidak Dilanjutkan'];
        return view('penyampaian.penyampaianEdit', [
            'title' => 'Edit Penyampaian Harmonisasi'
        ], compact('getHarmonisasi', 'rancangan', 'status', 'statusPenyampaian', 'pdraf'));
    }

    public function update(harmonisasi $harmonisasi, Request $request)
    {
        $valid = [
            'status' => 'required',
            'keterangan' => 'nullable',
            'docx1' => 'nullable|mimes:pdf,doc,docx,xlsx,xls,csv|max:5000|file',
            'docx2' => 'nullable|mimes:pdf,doc,docx,xlsx,xls,csv|max:5000|file',
            'docx3' => 'nullable|mimes:pdf,doc,docx,xlsx,xls,csv|max:5000|file',
            // 'docx4' => 'nullable|mimes:pdf,doc,docx,xlsx,xls,csv|max:5000|file',
            // 'docx5' => 'nullable|mimes:pdf,doc,docx,xlsx,xls,csv|max:5000|file',
        ];
        
        $data = $request->input();
        if(!empty($data['pdraf'])) {
            $valid['pdraf'] = 'exists:pdraf,id';
        }
        
        $request->validate($valid);
        $dataFile = $request->file();

        // check Doc
            if($request->file('docx1') && $harmonisasi->doc_administrasi->docx1 != null) {
                Storage::delete($harmonisasi->doc_administrasi->docx1);
                $docx1 = $dataFile['docx1']->store('document');
            } elseif ($request->file('docx1')) {
                $docx1 = $dataFile['docx1']->store('document');
            } else {
                $docx1 = $harmonisasi->doc_administrasi->docx1;
            }

            if($request->file('docx2') && $harmonisasi->doc_rapat->docx1 != null) {
                Storage::delete($harmonisasi->doc_rapat->docx1);
                $docx2 = $dataFile['docx2']->store('document');
            } elseif ($request->file('docx2')) {
                $docx2 = $dataFile['docx2']->store('document');
            } else {
                $docx2 = $harmonisasi->doc_rapat->docx1;
            }

            if($request->file('docx3') && $harmonisasi->doc_penyampaian->docx1 != null) {
                Storage::delete($harmonisasi->doc_penyampaian->docx1);
                $docx3 = $dataFile['docx3']->store('document');
            } elseif ($request->file('docx3')) {
                $docx3 = $dataFile['docx3']->store('document');
            } else {
                $docx3 = $harmonisasi->doc_penyampaian->docx1;
            }
        // End check Doc

        // input doc harmonisasi
        doc_administrasi::where('harmonisasi_id', $harmonisasi->id)->update([
            'docx1' => $docx1,
        ]);
        doc_rapat::where('harmonisasi_id', $harmonisasi->id)->update([
            'docx1' => $docx2,
        ]);
        doc_penyampaian::where('harmonisasi_id', $harmonisasi->id)->update([
            'keterangan' => $data['keterangan'],
            'docx1' => $docx3,
        ]);

        $data_edit = ['status_penyampaian' => $data['status']];
        if (!empty($data['pdraf'])) {
            $data_edit['pdraf_id'] = $data['pdraf'];
        }
        if ($data['status'] == 'Selesai Harmonisasi') {
            $data_edit['waktu_selesai']=date('Y-m-d H:i:s');
            $padministrasi_id = padministrasi::where('nama', 'Selesai Harmonisasi')->first('id');
            // $harmonisasi_id = harmonisasi::where('id', $harmonisasi->id)->first();
            $data_edit['padministrasi_id'] =  $padministrasi_id->id;
            harmonisasi::where('judul', $harmonisasi->judul)
            ->update($data_edit);
        } else {
            harmonisasi::where('judul', $harmonisasi->judul)
            ->update($data_edit);
        }

        return redirect('/penyampaian')->with('success', 'Berhasil Update Data');
    }

    // public function destroy1(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_penyampaian->docx1);
    //     doc_penyampaian::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx1' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }

    // public function destroy2(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_penyampaian->docx2);
    //     doc_penyampaian::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx2' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }

    // public function destroy3(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_penyampaian->docx3);
    //     doc_penyampaian::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx3' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }

    // public function destroy4(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_penyampaian->docx4);
    //     doc_penyampaian::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx4' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }

    // public function destroy5(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_penyampaian->docx5);
    //     doc_penyampaian::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx5' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }
}
