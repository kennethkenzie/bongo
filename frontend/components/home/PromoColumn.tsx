import { promoTiles } from "@/lib/data";

export default function PromoColumn() {
  return (
    <div className="hidden xl:flex w-[260px] shrink-0 flex-col gap-2">
      {promoTiles.slice(0, 3).map((p) => (
        <div key={p.title} className="card overflow-hidden relative group cursor-pointer">
          <div className="relative h-[108px]">
            {/* eslint-disable-next-line @next/next/no-img-element */}
            <img src={p.image} alt={p.title} className="absolute inset-0 w-full h-full object-cover" />
            <div className="absolute inset-0 bg-gradient-to-r from-white/95 via-white/60 to-transparent" />
            <div className="relative h-full flex flex-col justify-center pl-3">
              <div className="text-xs text-brand-700 font-semibold">{p.title}</div>
              <div className="text-base font-bold text-ink leading-tight">{p.subtitle}</div>
              <button className="mt-1 text-[11px] text-white bg-brand-600 px-2 py-1 rounded-sm self-start">
                {p.cta} →
              </button>
            </div>
          </div>
        </div>
      ))}
    </div>
  );
}
