import { Sparkles, Coins, Truck, BadgePercent } from "lucide-react";

const blocks = [
  { title: "Welcome Deal", subtitle: "Up to 50% off", color: "from-brand-600 to-brand-400", Icon: Sparkles },
  { title: "Bongo Coins", subtitle: "Earn while you shop", color: "from-amber-500 to-orange-400", Icon: Coins },
  { title: "Free Shipping", subtitle: "Orders over $10", color: "from-emerald-500 to-teal-400", Icon: Truck },
  { title: "Top Brands", subtitle: "Up to 80% off", color: "from-pink-500 to-rose-400", Icon: BadgePercent },
];

export default function PromoStrip() {
  return (
    <div className="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-3 mt-3">
      {blocks.map(({ title, subtitle, color, Icon }) => (
        <div
          key={title}
          className={`relative card overflow-hidden p-3 bg-gradient-to-br ${color} text-white cursor-pointer hover:shadow-pop transition`}
        >
          <div className="text-xs font-semibold opacity-90">{title}</div>
          <div className="text-lg font-extrabold leading-tight">{subtitle}</div>
          <Icon className="absolute right-2 bottom-1 opacity-25" size={48} strokeWidth={1.6} />
          <button className="mt-2 text-[11px] bg-white/95 text-brand-700 px-2 py-1 rounded-sm font-semibold">
            Shop now →
          </button>
        </div>
      ))}
    </div>
  );
}
