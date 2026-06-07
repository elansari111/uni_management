@extends('layouts.app')

@section('title', 'Espace Classroom - PFM')
@section('header_title', 'Espace Classroom')

@section('content')
<div class="space-y-6">
    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase">Module</p>
                <h2 class="text-xl font-extrabold text-slate-900">{{ $module->name }} <span class="text-slate-400 font-semibold">({{ $module->code }})</span></h2>
                <p class="text-sm text-slate-500">{{ $module->group?->name ?? 'Sans groupe' }}</p>
            </div>
            <a href="{{ route('teacher.modules') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                <h4 class="text-base font-bold text-slate-900 mb-4">Publier une annonce</h4>
                <form action="{{ route('teacher.classroom.announcements.store', $module->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Titre</label>
                        <input type="text" name="title" id="title" required
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="content" class="block text-sm font-medium text-slate-700 mb-1">Contenu</label>
                        <textarea name="content" id="content" rows="4" required
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="is_pinned" value="1" class="rounded border-slate-300">
                            Épingler
                        </label>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-sm font-semibold transition-colors cursor-pointer">
                            Publier
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h4 class="text-base font-bold text-slate-900">Annonces</h4>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($announcements as $ann)
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm font-extrabold text-slate-900">
                                        {{ $ann->title }}
                                        @if($ann->is_pinned)
                                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Épinglée</span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Par {{ $ann->creator?->name ?? 'Professeur' }} • {{ optional($ann->published_at)->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm text-slate-700 mt-4 whitespace-pre-line">{{ $ann->content }}</p>

                            <div class="mt-5">
                                <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Commentaires</p>
                                <div class="space-y-3">
                                    @forelse($ann->comments as $c)
                                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                            <p class="text-xs text-slate-500 font-semibold">{{ $c->user?->name ?? 'Utilisateur' }}</p>
                                            <p class="text-sm text-slate-700 mt-1 whitespace-pre-line">{{ $c->content }}</p>
                                        </div>
                                    @empty
                                        <p class="text-sm text-slate-400">Aucun commentaire.</p>
                                    @endforelse
                                </div>

                                <form action="{{ route('teacher.announcements.comments.store', $ann->id) }}" method="POST" class="mt-4 flex gap-3">
                                    @csrf
                                    <input type="text" name="content" required placeholder="Ajouter un commentaire..."
                                        class="flex-1 px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                                    <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-sm font-semibold transition-colors cursor-pointer">
                                        Envoyer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-slate-400">Aucune annonce pour le moment.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm">
                <h4 class="text-base font-bold text-slate-900 mb-4">Déposer un support</h4>
                <form action="{{ route('teacher.classroom.materials.store', $module->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="m_title" class="block text-sm font-medium text-slate-700 mb-1">Titre</label>
                        <input type="text" name="title" id="m_title" required
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="m_desc" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                        <textarea name="description" id="m_desc" rows="3"
                            class="block w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
                    </div>
                    <div>
                        <label for="file" class="block text-sm font-medium text-slate-700 mb-1">Fichier</label>
                        <input type="file" name="file" id="file" required
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-colors">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition-colors cursor-pointer text-sm">
                        Ajouter
                    </button>
                </form>
            </div>

            <div class="bg-white border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h4 class="text-base font-bold text-slate-900">Supports</h4>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($materials as $m)
                        <div class="p-6 flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $m->title }}</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $m->file_type }} • {{ $m->uploader?->name ?? 'Professeur' }}
                                    @if($m->published_at)
                                        • {{ $m->published_at->format('d/m/Y H:i') }}
                                    @endif
                                </p>
                                @if($m->description)
                                    <p class="text-sm text-slate-700 mt-3 whitespace-pre-line">{{ $m->description }}</p>
                                @endif
                            </div>
                            <a href="{{ asset('storage/' . $m->file_path) }}" download class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl transition-colors">
                                Télécharger
                            </a>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-slate-400">Aucun support publié.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
