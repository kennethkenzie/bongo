"use client";
import { heroSlides } from "@/lib/data";
import { useEffect, useState } from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";

export default function HeroBanner() {
  const [i, setI] = useState(0);
  useEffect(() => {
    const id = setInterval(() => setI((p) => (p + 1) % heroSlides.length), 5000);
    return () => clearInterval(id);
  }, []);
  const slide = heroSlides[i];
  return (
    <div className="relative flex-1 min-w-0 card overflow-hidden">
      <div className={`relative h-[220px] md:h-[300px] lg:h-[340px] bg-gradient-to-br ${slide.bg}`}>
        {/* eslint-disable-next-line @next/next/no-img-element */}
        <img
          src={slide.image}
          alt={slide.title}
          className="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-70"
        />
        <div className="relative h-full flex flex-col justify-center px-6 md:px-10 text-white max-w-xl">
          <div className="text-xs uppercase tracking-widest opacity-90">Estate Bongo Online</div>
          <h2 className="text-2xl md:text-4xl font-extrabold mt-2 drop-shadow">{slide.title}</h2>
          <p className="mt-1 md:mt-2 text-sm md:text-base opacity-95">{slide.subtitle}</p>
          <button className="mt-3 md:mt-4 self-start bg-white text-brand-700 px-4 py-2 rounded-sm font-semibold hover:bg-brand-50 transition">
            {slide.cta}
          </button>
        </div>

        <button
          onClick={() => setI((p) => (p - 1 + heroSlides.length) % heroSlides.length)}
          className="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 grid place-items-center bg-white/70 hover:bg-white text-ink rounded-sm"
          aria-label="Previous"
        >
          <ChevronLeft size={18} />
        </button>
        <button
          onClick={() => setI((p) => (p + 1) % heroSlides.length)}
          className="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 grid place-items-center bg-white/70 hover:bg-white text-ink rounded-sm"
          aria-label="Next"
        >
          <ChevronRight size={18} />
        </button>

        <div className="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5">
          {heroSlides.map((_, idx) => (
            <button
              key={idx}
              onClick={() => setI(idx)}
              className={`h-1.5 rounded-sm transition-all ${idx === i ? "w-6 bg-white" : "w-2 bg-white/50"}`}
              aria-label={`Slide ${idx + 1}`}
            />
          ))}
        </div>
      </div>
    </div>
  );
}
