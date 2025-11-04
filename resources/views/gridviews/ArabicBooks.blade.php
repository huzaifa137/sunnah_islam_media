@extends('layouts.Books_header_and_footer')
@section('Book_Information')
    </div>
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="books-gird">
                <ul>
                    @if($data->isEmpty())
                        <div class="alert alert-warning text-warning text-center" role="alert">
                            <strong>No books found!</strong> Please check back later.
                        </div>
                    @else
                        @foreach ($data as $info)
                            <li>
                                <figure>
                                    <img class="image-size" src="{{ asset('public/public/BookImage/' . $info->Book_Image) }}"
                                        alt="Book">
                                    <figcaption>
                                        <p><strong>{{ $info->Book_Name ?? 'Unknown Title' }}</strong></p>
                                        <p><strong>Author:</strong> {{ $info->Author_Name ?? 'Unknown Author' }}</p>
                                    </figcaption>
                                </figure>

                                <div class="book-list-icon yellow-icon"></div>
                                <div class="single-book-box">
                                    <div class="post-detail">
                                        <div class="books-social-sharing">
                                            <ul>
                                                <li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="fa fa-rss"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="fa fa-linkedin"></i></a></li>
                                            </ul>
                                        </div>

                                        <div class="optional-links">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Add To Cart"><i
                                                            class="fa fa-shopping-cart"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Like"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Mail"><i class="fa fa-envelope"></i></a>
                                                </li>
                                                <li><a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a>
                                                </li>
                                                <li><a href="javascript:void(0)" title="Print"><i class="fa fa-print"></i></a></li>
                                            </ul>
                                        </div>

                                        <header class="entry-header">
                                            <h3 class="entry-title">
                                                <a href="{{ url('final-page/' . $info->id) }}">
                                                    {{ $info->Book_Name ?? 'Untitled Book' }}
                                                </a>
                                            </h3>
                                            <ul>
                                                <li><strong>Author:</strong> {{ $info->Author_Name ?? 'Unknown' }}</li>
                                                <li><strong>Language:</strong> {{ $info->Language ?? 'N/A' }}</li>
                                            </ul>
                                        </header>

                                        <div class="entry-content">
                                            <p>{{ $info->Description ?? 'No description available for this book.' }}</p>
                                        </div>

                                        <footer class="entry-footer">
                                            <a class="btn btn-primary" href="{{ url('final-page/' . $info->id) }}">Read More</a>
                                        </footer>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <span>
                {{$data->links()}}
            </span>

            <style>
                .w-5 {
                    display: none;
                }
            </style>
        </div>
        <div class="col-md-3 col-md-pull-9">
            <aside id="secondary" class="sidebar widget-area" data-accordion-group>
                <div class="widget widget_related_search open" data-accordion>
                    <h4 class="widget-title" data-control>Related Searches</h4>
                    <div data-content>
                        <div data-accordion>
                            <h5 class="widget-sub-title" data-control>Subject</h5>
                            <div class="widget_categories" data-content>
                                <ul>
                                    <li><a href="{{url('search/Aqeedah')}}">AQEEDAH </span></a></li>
                                    <li><a href="{{url('search/Shirk')}}">SHIRK </span></a></li>
                                    <li><a href="{{url('search/Quran')}}">QURAN</span></a></li>
                                    <li><a href="{{url('search/Hadith')}}">HADITH</a></li>
                                    <li><a href="{{url('search/Prophets')}}">PROPHETS </span></a></li>
                                    <li><a href="{{url('search/Tafsir')}}">TAFSIR</span></a></li>
                                    <li><a href="{{url('search/Tawheed')}}">TAWHEED</span></a></li>
                                    <li><a href="{{url('search/Allah')}}">ALLAH</a></li>
                                    <li><a href="{{url('search/Angels')}}">ANGELS </span></a></li>
                                    <li><a href="{{url('search/Dua-zikr')}}">DUA-ZIKR </span></a></li>
                                    <li><a href="{{url('search/Jiin')}}">JINN</span></a></li>
                                    <li><a href="{{url('search/Sunnah')}}">SUNNAH</a></li>
                                    <li><a href="{{url('search/Bidah')}}">BIDAH</span></a></li>
                                    <li><a href="{{url('search/Biographies')}}">BIOGRAPHIES</span></a></li>
                                    <li><a href="{{url('search/Death-grave')}}">DEATH-GRAVE</span></a></li>
                                    <li><a href="{{url('search/Fiqh')}}">FIQH</a></li>
                                    <li><a href="{{url('search/New muslims')}}">NEW MUSLIMS</span></a></li>
                                    <li><a href="{{url('search/Non-Muslims')}}">Non-Muslims</span></a></li>
                                    <li><a href="{{url('search/Healing')}}">HEALING</span></a></li>
                                    <li><a href="{{url('search/Heart')}}">HEART</a></li>
                                    <li><a href="{{url('search/Kufar-Celebrations')}}">KUFAR-Celebrations</span></a></li>
                                    <li><a href="{{url('search/Qayamat-Hereafter')}}">Qayamat-HEREAFTER</span></a></li>
                                    <li><a href="{{url('search/Ramadhan')}}">RAMADHAN</span></a></li>
                                    <li><a href="{{url('search/Ruqya')}}">RUQYA </span></a></li>
                                    <li><a href="{{url('search/Salaf')}}">SALAF </span></a></li>
                                    <li><a href="{{url('search/Sins')}}">SINS</span></a></li>
                                    <li><a href="{{url('search/Islam-4-kids')}}">ISLAM-4-KIDs</a></li>
                                    <li><a href="{{url('search/Islam-sharia-will')}}">ISLAMI-SHARIA-WILL </span></a></li>
                                    <li><a href="{{url('search/Prophet-saws')}}">PROPHET-SAWS</span></a></li>
                                    <li><a href="{{url('search/Sacred-months')}}">SACRED-MONTHS</span></a></li>
                                    <li><a href="{{url('search/Advice')}}">ADVICE</a></li>
                                    <li><a href="{{url('search/Awliyah-Allah')}}">AWLIYAH-ALLAH </span></a></li>
                                    <li><a href="{{url('search/Benefits')}}">BENEFITS</span></a></li>
                                    <li><a href="{{url('search/Calamities')}}">CALAMITIES</span></a></li>
                                    <li><a href="{{url('search/Children-youth')}}">CHILDREN-YOUTH</a></li>
                                    <li><a href="{{url('search/Current-affairs')}}">CURRENT-AFFAIRS</span></a></li>
                                    <li><a href="{{url('search/Dajjal')}}">DAJJAL</span></a></li>
                                    <li><a href="{{url('search/Dawah')}}">DAWAH</span></a></li>
                                    <li><a href="{{url('search/Desires')}}">DESIRES</a></li>
                                    <li><a href="{{url('search/Envy')}}">ENVY</span></a></li>
                                    <li><a href="{{url('search/Ethics-manner')}}">ETHICS-MANNERS</span></a></li>
                                    <li><a href="{{url('search/Evil')}}">EVIL</span></a></li>
                                    <li><a href="{{url('search/Fatawa')}}">FATAWA</a></li>
                                    <li><a href="{{url('search/Fitnah')}}">FITNAH</span></a></li>
                                    <li><a href="{{url('search/Hajj-Umrah')}}">HAJJ-UMRAH</span></a></li>
                                    <li><a href="{{url('search/Halal-o-Haram')}}">HALAL-o-HARAM</span></a></li>
                                    <li><a href="{{url('search/Harram-Khutabhs')}}">HARRAM-KHUTABHs</span></a></li>
                                    <li><a href="{{url('search/Hijab')}}">HIJAB</a></li>
                                    <li><a href="{{url('search/History')}}">HISTORY </span></a></li>
                                    <li><a href="{{url('search/Ilm-Ulama')}}">ILM-ULAMA</span></a></li>
                                    <li><a href="{{url('search/Islam')}}">ISLAM</span></a></li>
                                    <li><a href="{{url('search/Islamic History')}}">ISLAMIC HISTORY</a></li>
                                    <li><a href="{{url('search/Janazah')}}">JANAZAH</span></a></li>
                                    <li><a href="{{url('search/Kufr')}}">KUFR</span></a></li>
                                    <li><a href="{{url('search/Modesty')}}">MODESTY</span></a></li>
                                    <li><a href="{{url('search/Marriage-divorce')}}">MARRIAGE-DIVORCE</a></li>
                                    <li><a href="{{url('search/Morals')}}">MORALS</span></a></li>
                                    <li><a href="{{url('search/Parents')}}">PARENTS</span></a></li>
                                    <li><a href="{{url('search/Prayers')}}">PRAYERS</span></a></li>
                                    <li><a href="{{url('search/Prophet\'S-family')}}">PROPHET'S-FAMILY</a></li>
                                    <li><a href="{{url('search/racism-injustice')}}">RACISM-INJUSTICE</span></a></li>
                                    <li><a href="{{url('search/Relations')}}">RELATIONS</span></a></li>
                                    <li><a href="{{url('search/Religions')}}">RELIGIONS</span></a></li>
                                    <li><a href="{{url('search/Repentance')}}">REPENTANCE</a></li>
                                    <li><a href="{{url('search/Rights')}}">RIGHTS</span></a></li>
                                    <li><a href="{{url('search/Zakat-sadaq')}}">ZAKAT-SADAQAH</span></a></li>
                                    <li><a href="{{url('search/Sahabah')}}">SAHABAH</span></a></li>
                                    <li><a href="{{url('search/sects')}}">SECTS</a></li>
                                    <li><a href="{{url('search/Seerah')}}">SEERAH</span></a></li>
                                    <li><a href="{{url('search/Sharia')}}">SHARIA</span></a></li>
                                    <li><a href="{{url('search/Shaytaan')}}">SHAYTAAN</span></a></li>
                                    <li><a href="{{url('search/Sisters')}}">SISTERS</a></li>
                                    <li><a href="{{url('search/Soul')}}">SOUL</span></a></li>
                                    <li><a href="{{url('search/Sufism')}}">SUFISM</span></a></li>
                                    <li><a href="{{url('search/Terrorism')}}">TERRORISM</span></a></li>
                                    <li><a href="{{url('search/Warnings')}}">WARNINGS</a></li>
                                    <li><a href="{{url('search/Waseela')}}">WASEELA</span></a></li>

                                </ul>
                            </div>
                        </div>

                        <div data-accordion>
                            <h5 class="widget-sub-title" data-control>Sheikhs</h5>
                            <div class="widget_categories" data-content>
                                <ul>
                                    {{-- <li><a href="{{url('search-ulaamah/sheikh Quraish Mazinga')}}">sheikh Quraish
                                            Mazinga</span></a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
            </aside>
        </div>
    </div>
    </div>

    @include('include.staff_picks')
    </div>
    </main>
    </div>
    </div>
    <!-- End: Products Section -->

@endsection