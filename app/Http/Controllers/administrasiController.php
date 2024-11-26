<?php

namespace App\Http\Controllers;

use App\Models\tahun;
use App\Models\doc_rapat;
use App\Models\rancangan;
use App\Models\pemrakarsa;
use App\Models\harmonisasi;
use Illuminate\Http\Request;
use App\Models\padministrasi;
use App\Models\doc_administrasi;
use App\Models\pdraf;
use Illuminate\Support\Facades\Storage;

class administrasiController extends Controller
{
    public function index()
    {
        $post_tahun = '';
        $post_harmonisasi = '';
        $post_pemrakarsa = '';
        $rancangan = rancangan::all();
        $tahun = tahun::all();
        $pemrakarsa = pemrakarsa::all();
        $pdraf = pdraf::all();
        $harmonisasi = harmonisasi::where('padministrasi_id', 2)->get();
        return view('administrasi.administrasi', [
            'title' => 'Administrasi Dan Analisis Konsepsi'
        ], compact('harmonisasi', 'post_tahun', 'post_harmonisasi', 'post_pemrakarsa', 'rancangan', 'tahun', 'pemrakarsa', 'pdraf'));
    }

    public function index_filter(Request $request)
    {
        $rancangan = rancangan::all();
        $tahun = tahun::all();
        $pemrakarsa = pemrakarsa::all();
        $data = $request->input();
        $post_tahun = $request->input('tahun');
        $pdraf = pdraf::all();
        $post_harmonisasi = $request->input('harmonisasi');
        $post_pemrakarsa = $request->input('pemrakarsa');
        $checkUser = auth()->user()->pemrakarsa_id;

        // filter tiga
        if ($data['tahun'] && $data['harmonisasi'] && $data['pemrakarsa']) {
            $filter_tahun = tahun::where('no', $data['tahun'])->first('id');
            $filter_rancangan = rancangan::where('nama', $data['harmonisasi'])->first('id');
            $filter_pemrakarsa = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');

            $harmonisasi = harmonisasi::where('padministrasi_id', 2)->where('rancangan_id', $filter_rancangan->id)->where('tahun_id', $filter_tahun->id)->where('pemrakarsa_id', $filter_pemrakarsa->id)->get();
        }
        // filter dua
        elseif ($data['tahun'] && $data['harmonisasi']) {
            $filter_tahun = tahun::where('no', $data['tahun'])->first('id');
            $filter_rancangan = rancangan::where('nama', $data['harmonisasi'])->first('id');

            $harmonisasi = harmonisasi::where('padministrasi_id', 2)->where('rancangan_id', $filter_rancangan->id)->where('tahun_id', $filter_tahun->id)->get();
        }
        elseif ($data['tahun'] && $data['pemrakarsa']) {
            $filter_tahun = tahun::where('no', $data['tahun'])->first('id');
            $filter_pemrakarsa = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');

            $harmonisasi = harmonisasi::where('padministrasi_id', 2)->where('pemrakarsa_id', $filter_pemrakarsa->id)->where('tahun_id', $filter_tahun->id)->get();
        }
        elseif ($data['harmonisasi'] && $data['pemrakarsa']) {
            $filter_rancangan = rancangan::where('nama', $data['harmonisasi'])->first('id');
            $filter_pemrakarsa = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');

            $harmonisasi = harmonisasi::where('padministrasi_id', 2)->where('pemrakarsa_id', $filter_pemrakarsa->id)->where('rancangan_id', $filter_rancangan->id)->get();
        }
        // Filter satu
        elseif ($data['tahun']) {
            $filter_tahun = tahun::where('no', $data['tahun'])->first('id');

            $harmonisasi = harmonisasi::where('padministrasi_id', 2)->where('tahun_id', $filter_tahun->id)->get();
        } 
        elseif ($data['harmonisasi']) {
            $filter_rancangan = rancangan::where('nama', $data['harmonisasi'])->first('id');

            $harmonisasi = harmonisasi::where('padministrasi_id', 2)->where('rancangan_id', $filter_rancangan->id)->get();
        } 
        elseif ($data['pemrakarsa']) {
            $filter_pemrakarsa = pemrakarsa::where('nama', $data['pemrakarsa'])->first('id');
            
            $harmonisasi = harmonisasi::where('padministrasi_id', 2)->where('pemrakarsa_id', $filter_pemrakarsa->id)->get();
        }

        return view('administrasi.administrasi', [
            'title' => 'Administrasi Dan Analisis Konsepsi'
        ], compact('rancangan', 'harmonisasi', 'tahun', 'pemrakarsa', 'post_tahun', 'post_harmonisasi', 'post_pemrakarsa', 'rancangan', 'tahun', 'pemrakarsa', 'pdraf'));
    }

    public function show(harmonisasi $harmonisasi)
    {
        $getHarmonisasi = $harmonisasi;
        $rancangan = $harmonisasi->rancangan->nama;
        
        $pdraf = pdraf::all();
        $status = ['Rapat Harmonisasi', 'Di Tolak'];
        return view('administrasi.administrasiEdit', [
            'title' => 'Edit Administrasi Dan Analisis Konsepsi'
        ], compact('getHarmonisasi', 'rancangan', 'status', 'pdraf'));
    }

    public function update(harmonisasi $harmonisasi, Request $request)
    {
        $valid = [
            'status' => 'required',
            'keterangan' => 'nullable',
            'docx1' => 'nullable|mimes:pdf,doc,docx,xlsx,xls,csv|max:5000|file',
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

            // if($request->file('docx2')  && $harmonisasi->doc_administrasi->docx2 != null) {
            //     Storage::delete($harmonisasi->doc_administrasi->docx2);
            //     $docx2 = $dataFile['docx2']->store('document');
            // } elseif ($request->file('docx2')) {
            //     $docx2 = $dataFile['docx2']->store('document');
            // } else {
            //     $docx2 = $harmonisasi->doc_administrasi->docx2;
            // }

            // if($request->file('docx3')  && $harmonisasi->doc_administrasi->docx3 != null) {
            //     Storage::delete($harmonisasi->doc_administrasi->docx3);
            //     $docx3 = $dataFile['docx3']->store('document');
            // } elseif ($request->file('docx3')) {
            //     $docx3 = $dataFile['docx3']->store('document');
            // } else {
            //     $docx3 = $harmonisasi->doc_administrasi->docx3;
            // }

            // if($request->file('docx4')  && $harmonisasi->doc_administrasi->docx4 != null) {
            //     Storage::delete($harmonisasi->doc_administrasi->docx4);
            //     $docx4 = $dataFile['docx4']->store('document');
            // } elseif ($request->file('docx4')) {
            //     $docx4 = $dataFile['docx4']->store('document');
            // } else {
            //     $docx4 = $harmonisasi->doc_administrasi->docx4;
            // }

            // if($request->file('docx5')  && $harmonisasi->doc_administrasi->docx5 != null) {
            //     Storage::delete($harmonisasi->doc_administrasi->docx5);
            //     $docx5 = $dataFile['docx5']->store('document');
            // } elseif ($request->file('docx5')) {
            //     $docx5 = $dataFile['docx5']->store('document');
            // } else {
            //     $docx5 = $harmonisasi->doc_administrasi->docx5;
            // }
        // End check Doc

        doc_administrasi::where('harmonisasi_id', $harmonisasi->id)
        ->update([
            'keterangan' => $data['keterangan'],
            'docx1' => $docx1,
            // 'docx2' => $docx2,
            // 'docx3' => $docx3,
            // 'docx4' => $docx4,
            // 'docx5' => $docx5
        ]);
            
            $data_edit = ['status_administrasi' => $data['status']];
        if (!empty($data['pdraf'])) {
            $data_edit['pdraf_id'] = $data['pdraf'];
        }
        
        if ($data['status'] == 'Rapat Harmonisasi') {
            $padministrasi_id = padministrasi::where('nama', 'Rapat Harmonisasi')->first('id');
            $harmonisasi_id = harmonisasi::where('id', $harmonisasi->id)->first();
            $rapat_id = doc_rapat::create([
                'harmonisasi_id' => $harmonisasi_id->id
            ]);
            
            $data_edit['padministrasi_id'] =  $padministrasi_id->id;
            $data_edit['doc_rapat_id'] = $rapat_id->id;
            harmonisasi::where('judul', $harmonisasi->judul)
            ->update($data_edit);
        } else {
            harmonisasi::where('judul', $harmonisasi->judul)
            ->update($data_edit);
        }

        return redirect('/administrasi')->with('success', 'Berhasil Update Data');
    }

    // public function destroy1(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_administrasi->docx1);
    //     doc_administrasi::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx1' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }

    // public function destroy2(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_administrasi->docx2);
    //     doc_administrasi::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx2' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }

    // public function destroy3(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_administrasi->docx3);
    //     doc_administrasi::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx3' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }

    // public function destroy4(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_administrasi->docx4);
    //     doc_administrasi::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx4' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }

    // public function destroy5(Harmonisasi $harmonisasi)
    // {
    //     Storage::delete($harmonisasi->doc_administrasi->docx5);
    //     doc_administrasi::where('harmonisasi_id', $harmonisasi->id)->update([
    //         'docx5' => ''
    //     ]);
    //     return back()->with('success', 'Berhasil Menghapus Dokumen');
    // }
}
