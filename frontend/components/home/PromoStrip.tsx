import { promoTiles } from "@/lib/data";

const blocks = [
  { title: "Welcome Deal", subtitle: "Up to 50% off", color: "from-brand-600 to-brand-400", emoji: "🎉" },
  { title: "Bongo Coins", subtitle: "Earn while you shop", color: "from-amber-500 to-orange-400", emoji: "🪙" },
  { title: "Free Shipping", subtitle: "Orders over $10", color: "from-emerald-500 to-teal-400", emoji: "🚚" },
  { title: "Top Brands", subtitle: "Up to 80% off", color: "from-pink-500 to-rose-400", emoji: "🏷️" }
];

export default function PromoStrip() {
  return (
    <div className="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-3 mt-3">
      {blocks.map((b) => (
        <div
          key={b.title}
          className={`relative card overflow-hidden p-3 bg-gradient-to-br ${b.color} text-white cursor-pointer hover:shadow-pop transition`}
        >
          <div className="text-xs font-semibold opacity-90">{b.title}</div>
          <div className="text-lg font-extrabold leading-tight">{b.subtitle}</div>
          <div className="absolute right-2 bottom-1 text-3xl opacity-90">{b.emoji}</div>
          <button className="mt-2 text-[11px] bg-white/95 text-brand-700 px-2 py-1 rounded-sm font-semibold">
            Shop now →
          </button>
        </div>
      ))}
    </div>
  );
}
